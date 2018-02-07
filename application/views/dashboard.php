<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <form action="post/create" method="POST">
                Title: <input type="text" name="title" placeholder="Title" class="form-control">
                Body: <textarea name="body" placeholder="Body" class="form-control"></textarea>
                <input type="submit" value="Submit" class="form-control">
            </form>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <form action="post/delete" method="POST">
                <input type="number" name="id" class="form-control">
                <input type="submit" value="submit" class="form-control">
            </form>
        </div>
    </div>
</div>

<div class="container-fluid mt-3 mb-3">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="usersTbl"></table>
                </div>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.3/css/select.bootstrap4.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.2.3/js/dataTables.select.min.js"></script>
<script type="text/javascript">
    (function() {
        var usersTbl;
        var updateUserBtn;

        function init() {
            updateUserBtn = $("#updateUserBtn");

            usersTbl = $("#usersTbl").DataTable({
                ajax: 'post/get',
                columns: [
                    { title: "Title", data: "title" },
                    { title: "Body", data: "body" },
                    { title: "Author", data: "author" },
                    { title: "Date Created", data: "created_at" }
                ]
            });
        }

        init();
    })();
</script>