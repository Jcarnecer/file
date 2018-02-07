<!-- start sidebar -->
<div id="sidebar" style="overflow-y: auto;">

    <div id="nav-icon-close" class="custom-toggle">
        <span></span>
        <span></span>
    </div>

    <ul class="sidebar-menu">
        <li class="">
            <a class="" href="
            	<?php
            		if(ENVIRONMENT==="development") {
                        echo "http://localhost/task/personal";
                    } else {
            			echo "http://task.payakapps.com/personal";
	            	}
            	?>">
                <i class="fa fa-tasks" aria-hidden="true"></i>
                <span>Personal Task</span>
            </a>    
        </li>
        
        <li class="sub-menu">
            <a data-toggle="collapse" href="#UIElementsSub1" aria-expanded="false" aria-controls="UIElementsSub1" >
                <i class="fa fa-folder" aria-hidden="true"></i>
                <span>Projects</span>
            </a>
            <ul class="sub collapse" id="UIElementsSub1">
                <?php foreach($projects as $project_instance): ?>
                <li><a href="<?= base_url('project/' . $project_instance['id']); ?>"><i class="fa fa-file"></i> <?=$project_instance['name']?></a></li>
                <?php endforeach; ?>
                <li>
                    <a class="team-create" href="#teamModifyModal" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> Add Project</a>
                </li>
            </ul>
        </li>
        
        <li class="">
            <a class="" href="<?= LOGOUT_URL ?>">
                <i class="fa fa-sign-out-alt" aria-hidden="true"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>

</div>
<!-- end sidebar -->
<div class="main-content h-100">

    <div class="topbar">
        <nav class="navbar navbar-custom clearfix">
            <div id="nav-icon-open" class="custom-toggle hidden-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <a class="navbar-brand font-weight-bold text-uppercase" href="<?= base_url('tasks'); ?>">
                <?= $project['name'] ?>
            </a>
            
            <span class="ml-auto">
                <a href="#" data-toggle="popover" data-placement="bottom"  data-content="<?= $user->email_address ?>" data-trigger="hover">
                    <img class="img-avatar mr-2" src="<?= $user->avatar_url ?>"><?= $user->first_name.' '.$user->last_name ?>
                </a>
            </span>
        </nav>
    </div>
    
    <div class="inner-content d-flex flex-column p-0">
        <div class="d-flex w-100 project-buttons">
            <a href="
                <?php
                    if(ENVIRONMENT==="development") {
                        echo "http://localhost/task/project/" . $project['id'];
                    } else {
                        echo "http://task.payakapps.com/project/" . $project['id'];
                    }
                ?>" class="btn btn-lg w-50 project-button rounded-0"><i class="fa fa-tasks"></i> Tasks</a>
            <a href="<?= base_url('/project/' . $project['id']) ?>" onclick="javascript:void(0)" class="btn btn-lg project-button active w-50 rounded-0"><i class="fa fa-exchange-alt"></i> Forum</a>
        </div>
        <div class="h-100 w-100" style="overflow-y: auto;">
