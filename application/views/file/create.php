<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card space-between">
                <h2 class="card-header">
                     <p class="d-inline-block message-header">New Thread    </p>
                </h2>
                <div class="card-block title-wrapper">
                    <form action="post/create/<?=$project_id?>" method="POST" class="message">
                         <div class="form-group comment-form">
                            <input type="text" name="title" placeholder="Title" class="form-control"></input>
                         </div>
                    </div>
                    <hr>
                    <div class="page-wrapper">
                        <textarea name="body" class="form-control" placeholder="Your Message" id="reply-system"></textarea>
                    </div>
                    <input type="submit" value="Submit" class="btn btn-primary float-right">
                </form>              
            </div>
        </div>

        <script>
        $(document).ready(function() {
            $('.content').richText();
            $('.richText-editor').html();
        });
        </script>
            
    </div>
    <!-- /.row -->

