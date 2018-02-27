<div class="container-fluid h-100">
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
            <div class="bg-light w-100 py-3 px-5 clearfix">
                <nav class="text-secondary float-left" style="font-size:1.5rem;"><?=$current_directory['name']?></nav>
                <div class="float-right">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#new_file_modal"><i class="fas fa-upload"></i>&nbsp;Upload File</button>

                    <!-- <button class="btn btn-info" data-toggle="modal" data-target="#new_dir_modal"><i class="fas fa-plus"></i>&nbsp;Add Folder</button> -->
                </div>

                <!-- <div class="modal fade" id="new_dir_modal" tabindex="-1" role="dialog" aria-labelledby="new_dir_modal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <?=form_open('FileController/make_new_folder', 'id="new_folder_form", name="new_folder_form"');?>
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
                        <?=form_close();?>
                    </div>
                </div> -->

                <div class="modal fade" id="new_file_modal" tabindex="-1" role="dialog" aria-labelledby="new_file_modal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <?=form_open_multipart('FileController/add_file', 'id="new_file_form", name="new_file_form"');?>
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
                            <?=form_close();?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dir-content p-0" style="flex:1;">
                    <table class="table table-hover">
                        <thead class="text-secondary">
                            <th class=""><span class="table-row-first">Name</span></th>
                            <th class="" style="width:15%;">Last Modified</td>
                            <th class="" style="width:15%;">Date Created</th>
                            <th class=""></th>
                        </thead>
                        <tbody id="file_browser">
                            <!-- AJAX FILES HERE -->
                        </tbody>
                    </table>

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
                                <a href="" class="btn btn-danger">Yes, I want to delete this file</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
</div>
<!-- /.row -->