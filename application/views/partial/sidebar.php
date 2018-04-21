<!-- start sidebar -->
<div id="sidebar" style="overflow-y: auto;">
    <div id="nav-icon-back">
        <a href="<?= ENVIRONMENT === 'development' ? 'http://localhost/main' : 'https://payakapps.com' ?>">
            <i style="color:#fff;height: 25px;position: relative;width:30px;" class="fa fa-arrow-left"></i>
        </a>
    </div>
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
            			echo "https://task.payakapps.com/personal";
	            	}
            	?>">
                <i class="fa fa-tasks" aria-hidden="true"></i>
                <span>Personal Tasks</span>
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

    <div class="topbar w-100" style="margin-bottom: -20px;">
        <nav class="navbar navbar-custom navbar-expand-lg">
            <div id="nav-icon-open" class="custom-toggle hidden-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <a class="navbar-brand" href="">
                <?= $project['name'] ?>
            </a>
            
            <ul class="navbar-nav flex-row ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <img class="img-avatar mr-2" src="<?= $user->avatar_url ?>"><?= $user->first_name . ' ' . $user->last_name ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="<?= ENVIRONMENT === "development" ? 'http://localhost/main/users/profile' : 'https://payakapps.com/users/profile' ?>">My Profile</a>
                        <a class="dropdown-item" href="<?= ENVIRONMENT === "development" ? 'http://localhost/main/users/profile/change-password' : 'https://payakapps.com/users/profile/change-password' ?>">My Password</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= LOGOUT_URL ?>">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
    
    <div class="inner-content d-flex flex-column p-0">
        <ul class="nav nav-tabs d-flex flex-nowrap project-buttons">
            <li class="nav-item w-100">
                <a href="<?= ENVIRONMENT === 'development' ? 'http://localhost/task/project/' . $project['id'] : 'https://task.payakapps.com//project/' . $project['id'] ?>" class="nav-link project-button" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-tasks"></i> Tasks</a>
            </li>
            <li class="nav-item w-100">
                <a href="<?= ENVIRONMENT === 'development' ? 'http://localhost/forum/project/' . $project['id'] : 'https://forum.payakapps.com//project/' . $project['id'] ?>" class="nav-link secondary-button"><i class="fa fa-exchange-alt"></i> Discussion</a>
            </li>
            <li class="nav-item w-100">
                <a href="<?= base_url('/project/' . $project['id']) ?>" onclick="javascript:void(0)" class="nav-link secondary-button active"  role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file"></i> Files</a>
            </li>
        </ul>
        <div class="h-100 w-100" style="overflow-y: auto;">
