<div class="container-fluid h-100" >
    <div class="row h-100">

        <!-- FILE TREE -->
        <!-- <section class="col-md-2 h-100 gen-dir p-0 border-right border-light">
            <div class="h-100 p-3 text-truncate" style="overflow:scroll;">
                <div class="text-truncate"><i class="fas fa-folder-open"></i>&nbsp;<?=$current_directory['name']?></div>
                <?php //foreach ($folders as $key => $value): ?>
                <div class="pl-4 text-truncate"><i class="fas fa-folder"></i>&nbsp;<?=$value['name']?></div>
                <?php //endforeach; ?>
            </div>
        </section> -->

        <!-- FILE BROWSER -->
        <section class="col-md h-100 p-0" style="display: flex; flex-direction: column;">
            <div class="bg-light w-100 py-3 px-5 clearfix" style="">
                <nav class="text-secondary float-left" style="font-size:1.5rem;"><?=$current_directory['name']?></nav>
                <div class="float-right">
                    <button id="upload_modal_trigger" class="btn btn-primary" data-toggle="modal" data-target="#new_file_modal"><i class="fas fa-upload"></i>&nbsp;Upload File</button>

                    <!-- <button class="btn btn-info" data-toggle="modal" data-target="#new_dir_modal"><i class="fas fa-plus"></i>&nbsp;Add Folder</button> -->
                </div>

                <!-- <div class="modal fade" id="new_dir_modal" tabindex="-1" role="dialog" aria-labelledby="new_dir_modal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <?=form_open('FileController/make_new_folder', 'id="new_folder_form", name="new_folder_form"');?>
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-title">Create New Folder</h5>
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
                        <?=form_close();?>
                    </div>
                </div> -->

                <div class="modal fade" id="new_file_modal" tabindex="-1" role="dialog" aria-labelledby="new_file_modal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <?=form_open_multipart('FileController/add_file', 'id="new_file_form", name="new_file_form"');?>
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-title">Upload New File</h5>
                                <button id='close_upload' type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col card p-3">
                                    <div class="progress m-3" id='progress' hidden>
                                        <div id="progressBar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                    </div>
                                    <p id="upload_status" class="text-center" hidden></p>
                                    <input type="file" class="w-100" id="new_file" name="new_file">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id='cancel_upload' type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button id='upload' type="submit" class="btn btn-primary" value="submit">Upload</button>
                            </div>
                            <?=form_close();?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-0" style="flex:1;" >
                <table class="table table-hover" >
                    <thead class="text-secondary">
                        <th class=""><span class="table-row-first">Name</span></th>
                        <th class="" style="width:15%;">Date Created</th>
                        <th class="" style="width:15%;">Last Modified</th>
                        <th class="" style="width:15%;">Modified By</th>
                        <th class="" style="width:15%;">Size</th>
                        <th class="" style="width:15%;"></th>
                    </thead>
                    <tbody id="file_browser" >
                        <!-- AJAX FILES HERE -->
                    </tbody>
                </table>

                <!-- ERROR MODAL -->
                <div id="error_modal" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog " role="document">
                        <div class="modal-content" style="background-color:pink;">
                            <div class="modal-header">
                                <h5 class="modal-title">Error!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <p class="font-weight-bold">Something has gone wrong.</p>
                                <p id="error_code" class="text-danger">error code: </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DELETE MODAL -->
                <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="DeleteFile" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="delete_modal_label">Confirm Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="">Are you sure you want to <span class="text-danger">delete</span> this file?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                                <button id="deleteFile_btn" data-fileid="" class="btn btn-danger">Yes, I want to delete this file</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
</div>
<!-- /.row -->