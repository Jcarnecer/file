<div class="container-fluid h-100" >
    <div class="row h-100">

        <!-- FILE BROWSER -->
        <section class="col-md h-100 p-0" style="display: flex; flex-direction: column;">
            <div class="bg-light w-100 py-3 px-5 clearfix" style="">
                <nav class="text-secondary float-left" style="font-size:1.5rem;"><?=$current_directory['name']?></nav>
                <div class="float-right">
                    <button id="bin_modal_trigger" type="button" class="btn btn-secondary mr-3" data-toggle="modal" data-target="#bin_modal"><i class="far fa-trash-alt"></i>&nbsp;View Bin</button>
                    <button id="upload_modal_trigger" type="button" class="btn btn-primary" data-toggle="modal" data-target="#new_file_modal"><i class="fas fa-upload"></i>&nbsp;Upload File</button>
                </div>

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
                                    <input type="file" class="w-100" id="new_file" name="new_file" accept=".txt,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf,.zip,.rar,.jpg,.gif,.png">
                                    <div class="mx-3" style="display:block" id="instructions">
                                        <hr/>
                                        <small>
                                            <ul class="list-unstyled">
                                                <li>File must not exceed <span class="text-info">5 MB</span></li>
                                                <li>Allowed file types:
                                                    <ul class="list-inline mx-4 text-info">
                                                        <li class="list-inline-item">.txt</li>
                                                        <li class="list-inline-item">.doc</li>
                                                        <li class="list-inline-item">.docx</li>
                                                        <li class="list-inline-item">.xls</li>
                                                        <li class="list-inline-item">.xlsx</li>
                                                        <li class="list-inline-item">.ppt</li>
                                                        <li class="list-inline-item">.pptx</li>
                                                        <li class="list-inline-item">.pdf</li>
                                                        <li class="list-inline-item">.jpg</li>
                                                        <li class="list-inline-item">.gif</li>
                                                        <li class="list-inline-item">.png</li>
                                                        <li class="list-inline-item">.zip</li>
                                                        <li class="list-inline-item">.rar</li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </small>
                                    </div>
                                    <div id="upload_status" class="text-center" hidden></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id='cancel_upload' type="button" class="btn btn-danger" hidden>Cancel</button>
                                <button id='retry_upload' type="button" class="btn btn-warning" hidden>Retry</button>
                                <button id='upload' type="submit" class="btn btn-primary" value="submit" disabled>Upload</button>
                            </div>
                            <?=form_close();?>
                        </div>
                    </div>
                </div>

                <div class="modal fade bd-example-modal-lg" id="bin_modal" tabindex="-1" role="dialog" aria-labelledby="bin_modal" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Bin</h5>
                                <button id='close_upload' type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col text-right">
                                            <button id="restore_btn" type="button" class="btn btn-primary mb-4" disabled="true">Restore</button>
                                        </div>
                                        <div class="w-100"></div>
                                        <div class="col">
                                            <table class="table w-100" id="fileBinTable">
                                                <thead class="text-secondary table-sm">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Deleted</th>
                                                        <th>Deleted By</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <p class="m-0"><i class="fas fa-info-circle"></i> Files sent to the bin will be permanently deleted after sixty (60) days.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <table class="table w-100" id="fileDataTable">
                    <thead class="text-secondary">
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Date Created</th>
                            <th>Last Modified</th>
                            <th>Modified By</th>
                            <th>Size</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
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
                                <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                <button id="deleteFile_btn" data-fileid="" class="btn btn-secondary">Yes, I want to delete this file</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
</div>
<!-- /.row -->