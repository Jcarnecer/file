<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FileController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        //@TODO add check if session exists
        $this->load->library('upload');
    }

    public function project($id)
    {

        $project = $this->project->get($id);
        $this->session->set_userdata(['project' => $project]);

        // creates new root folder of project if there is none
        $folder = $this->folder->get($id);
        if (!isset($folder)) {
            $data = [
                'id' => $id,
                'name' => $project['name'],
                'root' => true,
            ];
            $this->folder->insert($data);
        }

        $data['current_directory'] = $this->folder
            ->with('file')
            ->get_by([
                'id' => $id,
                'root' => true,
            ]);

        return parent::main_page("file/index", $data ?? null);
    }

    public function get_dir_contents()
    {
        $id = $this->session->project['id'];
        $data['current_directory'] = $this->folder
            ->with('file')
            ->get_by([
                'id' => $id,
                'root' => true,
            ]);

        echo json_encode($data);
    }

    public function get_bin_contents()
    {
        $id = $this->session->project['id'];
        $data['project_bin'] = $this
            ->file
            ->only_deleted()
            ->get_many_by([
                'location' => $id,
            ]);

        echo json_encode($data);
    }

    public function add_file()
    {
        $this->load->library('Utilities');
        

        $gen_file_name = $this->utilities->create_random_string(11); // create file name

        $config['file_name'] = $gen_file_name;
        $config['upload_path'] = './assets/uploads/';
        $config['allowed_types'] = 'txt|doc|docx|xls|xlsx|ppt|pptx|pdf|zip|rar|jpg|gif|png';
        $config['max_size'] = 5000; //5MB Max upload Size
        $config['max_filename'] = 255;
        $config['max_filename_increment'] = 999;
        $config['remove_spaces'] = true;

        $this->upload->initialize($config);

        $status_msg = '';

        if (!$this->upload->do_upload('new_file')) {
            $status_msg = array('error' => $this->upload->display_errors());
            echo json_encode($status_msg);
        } else {
            // transfer uploaded file to S3
            $file = FCPATH . 'assets\\uploads\\' . $this->upload->data('file_name');
            $result = $this->s3->uploadFile($file);

            if ($result['code'] == 0){
                // insert to database
                $new_file_data = array(
                    'id' => $gen_file_name,
                    'name' => $this->upload->data('client_name'),
                    'location' => $this->session->project['id'],
                    'company_id' => $this->session->project['company_id'],
                    'size' => $this->upload->data('file_size'),
                    'created_by' => $this->session->user->id,
                    'updated_by' => $this->session->user->id,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                    'deleted' => 0,
                    'source' => $result['data']
                );
                
                if ($this->file->insert($new_file_data)) {
                    $status_msg = array('error' => 'Database Connection Error');
                }

                // remove the file from the server
                unlink($file);
                $status_msg = array('success' => $result['msg']);
            } else {
                $status_msg = array('error' => 'Upload to S3 Server Failed');
            }

            echo json_encode($status_msg);
        }
    }

    public function delete_file($id)
    {
        $filename = explode("/", $this->file->get($id)['source'])[5];

        $result = $this->s3->binFile($filename);

        if ($result['code'] == 0) {
            if ($this->file->delete($id)) {
                $status_msg = array('success' => 'Delete Success');
            } else {
                $status_msg = array('error' => 'Database connection error.');
            }
        } else {
            $status_msg = array('error' => 'AWS S3 Connection error.');
        }

        echo json_encode($status_msg);
    }

    public function restore_file($id)
    {
        $filename = explode("/", $this->file->only_deleted()->get($id)['source'])[5];

        $result = $this->s3->restoreFile($filename);

        if ($result['code'] == 0) {
            if ($this->file->update($id, array('deleted' => '0'))) {
                $status_msg = array('success' => 'File Restored');
            } else {
                $status_msg = array('error' => 'Database connection error.');
            }
        } else {
            $status_msg = array('error' => 'AWS S3 Connection error.');
        }

        echo json_encode($status_msg);
    }

    public function permanent_delete($id)
    {
        $filename = explode("/", $this->file->only_deleted()->get($id)['source'])[5];

        $result = $this->s3->deleteFile($filename);

        if ($result['code'] == 0) {
            if ($this->file->permanent_delete($id)) {
                $status_msg = array('success' => 'File permanently deleted');
            } else {
                $status_msg = array('error' => 'Database connection error.');
            }
        } else {
            $status_msg = array('error' => 'AWS S3 Connection error.');
        }

        echo json_encode($status_msg);
    }

    public function getIconClass($file_ext)
    {
        $supported_files = array(
            'txt' => 'fa-file',
            'doc' => 'fa-file-word',
            'docx' => 'fa-file-word',
            'xls' => 'fa-file-excel',
            'xlsx' => 'fa-file-excel',
            'ppt' => 'fa-file-powerpoint',
            'pptx' => 'fa-file-powerpoint',
            'pdf' => 'fa-file-pdf',
            'zip' => 'fa-file-archive',
            'rar' => 'fa-file-archive',
            'jpg' => 'fa-file-image',
            'gif' => 'fa-file-image',
            'png' => 'fa-file-image',
        );

        echo json_encode($supported_files["$file_ext"]);
    }

    /* ************** These are functions to be used when creating new folders.. to be updated ***************** @author JM
public function create_folder($id) {
$data = [
'id' => //generate id,
'name'=> $this->input->post('name'),
'location' => $id,
'root' => FALSE
];

return $this->folder->insert($data);
}

public function update_folder($id) {
$data = [
'name' => $this->input->post('name'),
'location' => $id
];

return $this->folder->update($data)
}

// new folder creation
public function make_new_folder() {
$this->load->library('Utilities');

//var_dump($this->session->project['id']); die;

$new_folder_data = array(
'id' => $this->utilities->create_random_string(11),
'name' => $this->input->post('new_folder_name'),
'type' => 'folder',
'parent' => $this->session->project['id'],
'company_id' => $this->session->project['company_id'],
'project_id' => $this->session->project['id'],
'owner_id' => $this->session->user->id
);

if ($this->Files_Model->create_folder($new_folder_data)) {
echo "ERROR IN INSERTING"; die;
}

$project_id = $this->session->project['id'];
redirect("project/$project_id");
}

public function show_all_contents() {
$result = $this->Files_model->get_contents();

$data['dirs'] = $result;
//var_dump($data['dirs']); die;
return parent::main_page("file/index", $data ?? null);

//echo json_encode($result);
}
 */

}
