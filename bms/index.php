<?php 

$parent = '';
$file = '';
$page = 'Dashboard';

include __DIR__ . '/header.php'; ?>

    <!-- Content area -->
    <div class="content pt-0">

        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Quick Draft</h6>
                    </div>
                    
                    <div class="card-body">
                        <form action="#">
                            <div class="mb-3">
                                <label class="form-label">Title:</label>
                                <input type="text" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Content:</label>
                                <textarea rows="4" cols="3" class="form-control" placeholder="What's on your mind?"></textarea>
                            </div>


                                <button type="submit" class="btn btn-primary">Save Draft</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Overview</h6>
                    </div>
                    
                    <div class="card-body">

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Recent Activities</h6>
                    </div>
                    
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /content area -->

<?php include __DIR__ . '/footer.php'; ?>