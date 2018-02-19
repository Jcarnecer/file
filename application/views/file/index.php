<div class="container-fluid h-100">
    <div class="row h-100">

        <section class="col-md h-100 gen-dir p-0 border-right border-light">
            <div class="h-100 p-3 text-truncate" style="overflow:scroll;">
                <div class="text-truncate"><i class="fas fa-folder-open"></i>&nbsp;<?= $this->session->project['name'] ?></div>
                <?php foreach ($folders as $key => $value): ?>
                <div class="pl-4 text-truncate"><i class="fas fa-folder"></i>&nbsp;<?= $value['name'] ?></div>
                <?php endforeach; ?>
            </div>
            
        </section>

        <section class="col-md-10 h-100 p-0" style="display: flex; flex-direction: column;">
            <div class="bg-light w-100 p-3 clearfix">
                <nav class="text-secondary float-left" style="font-size:1.5rem;"><?= $this->session->project['name'] ?>/</nav>
                <div class="float-right">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#new_file_modal"><i class="fas fa-upload"></i>&nbsp;Upload File</button>
                    <button class="btn btn-info" data-toggle="modal" data-target="#new_dir_modal"><i class="fas fa-plus"></i>&nbsp;Add Folder</button>
                </div>

                <div class="modal fade" id="new_dir_modal" tabindex="-1" role="dialog" aria-labelledby="new_dir_modal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <?= form_open('FileController/make_new_folder', 'id="new_folder_form", name="new_folder_form"'); ?>
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Create New Folder</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            
                            <input type="text" class="form-control" id="new_folder_name" name="new_folder_name" aria-describedby="newfolder" placeholder="Enter Folder Name" required>
                            <small id="folderHelp" class="form-text text-muted text-italic"><b>Avoid Spaces.</b> <i>Use hypens instead.</i>&nbsp;&nbsp;eg. new-project-instructions</small>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" value="submit">Save changes</button>
                        </div>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>

                <div class="modal fade" id="new_file_modal" tabindex="-1" role="dialog" aria-labelledby="new_file_modal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <?= form_open_multipart('FileController/add_file', 'id="new_file_form", name="new_file_form"'); ?>
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Upload New File</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col card p-3">
                                    <input type="file" class="w-100" id="new_file" name="new_file">
                                </div>
                                <?php //echo $error;?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" value="submit">Upload</button>
                            </div>
                            <?= form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dir-content p-0" style="flex:1; padding: 1rem;">
                <table class="table table-lg text-secondary p-5">
                    <thead>
                        <th class="col-1"></th>
                        <th class="col-3">Name</th>
                        <th class="col-2">Type</th>
                        <th class="col-3">Last Modified</td>
                        <th class="col-3"> Date Created</th>
                    </thead>
                    <tbody>
                        <?php foreach ($current_dir_contents as $key => $value): ?>
                            <tr id='item[<?= $value["id"]?>]'>
                                <td class="align-middle text-center">
                                    <?php if ($value['type'] === "folder"): ?>
                                        <i class="fas fa-folder fa-2x"></i>
                                    <?php else: ?>
                                        <i class="fas fa-file fa-2x"></i>
                                    <?php endif; ?>
                                </td>
                                <td class="align-middle">
                                    <h5><?= $value['name'] ?></h5>
                                </td>
                                <td class="align-middle">
                                    <p><?= $value['type'] ?></p>
                                </td>
                                <td class="align-middle">
                                    <p><?= $value['date_modified'] ?></p>
                                </td>
                                <td class="align-middle">
                                    <p><?= $value['date_modified'] ?></p>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
<!-- /.row -->