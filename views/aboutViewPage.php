<?php
    include '../views/templates/header.php';
    include '../views/templates/navbar.php';
?>
<section class = 'container'>
    <div class="aboutViewHeader p-3">
        <h1>Team <i class="fas fa-users"></i></h1>

    </div>
    <div class="list-group p-3">
        <a href="#" class="list-group-item list-group-item-action list-group-item-success" aria-current="true">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1"> Daniel Capacio <i class="fas fa-id-badge"></i></h6>
                <small>69646362</small>
            </div>
            <p class="mb-1">danielcapacio@gmail.com <i class="far fa-envelope"></i></p>
            <small>University of British Columbia <i class="fas fa-school"></i></small>
        </a>
        <a href="#" class="list-group-item list-group-item-action list-group-item-primary">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1">Dennis Zheng <i class="fas fa-id-badge"></i></h6>
                <small class="text-muted">83006460</small>
            </div>
            <p class="mb-1">denniszhengsky@gmail.com <i class="far fa-envelope"></i></p>
            <small class="text-muted">University of British Columbia <i class="fas fa-school"></i></small>
        </a>
        <a href="#" class="list-group-item list-group-item-action list-group-item-info">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1"> Derryl Sayo <i class="fas fa-id-badge"></i></h6>
                <small class="text-muted">97747976</small>
            </div>
            <p class="mb-1">derrylmsayo@gmail.com <i class="far fa-envelope"></i></p>
            <small class="text-muted">University of British Columbia <i class="fas fa-school"></i></small>
        </a>
    </div>

    <div class="row center">
        <div class="col-4">
            <div class="list-group" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active list-group-item-success" id="list-projectInfo-list" data-bs-toggle="list" href="#list-projectInfo" role="tab" aria-controls="list-projectInfo">About Our Project <i class="fas fa-project-diagram"></i></a>
                <a class="list-group-item list-group-item-action list-group-item-success" id="list-date-list" data-bs-toggle="list" href="#list-date" role="tab" aria-controls="list-date">Project Finished Date <i class="fas fa-calendar-alt"></i></a>
                <a class="list-group-item list-group-item-action list-group-item-success" id="list-course-list" data-bs-toggle="list" href="#list-course" role="tab" aria-controls="list-Course">Course Info <i class="fas fa-database"></i></a>

            </div>
        </div>
        <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade textAlign show active fs-4 list-group-item-success" id="list-projectInfo" role="tabpanel" aria-labelledby="list-projectInfo-list">
                    This browser client gives tenants and landlords easy access to manage required payments,
                    overlook room information, quickly book building amenities, and organize move-in procedures.</div>
                <div class="tab-pane fade show titleAlign fs-2 list-group-item-success" id="list-date" role="tabpanel" aria-labelledby="list-date-list">2021-06-16</div>
                <div class="tab-pane fade titleAlign fs-3 list-group-item-success" id="list-course" role="tabpanel" aria-labelledby="list-course-list">CPSC-304 2021S1 Introduction to Relational Database</div>
            </div>
        </div>
    </div>

</section>
    <link href="../css/aboutViewPageStyle.css" rel="stylesheet">
    <?php include '../views/templates/footer.php'; ?>