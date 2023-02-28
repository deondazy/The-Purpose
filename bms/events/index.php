<?php 

use Core\Utility;

require_once __DIR__ . '/../../bootstrap.php';

$parent = 'events/';
$file = $parent;
$page = 'Events';

include __DIR__ . '/../header.php'; 
?>

<style>
    .actions {
        visibility: hidden;
    }
    tr:hover .actions {
        visibility: visible;
    }
    #image-preview {
        display: none;
        max-width: 100%;
        margin-bottom: 0.5rem;
    }
</style>

    <!-- Content area -->
    <div class="content pt-0">
        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Add New Event</h6>
                    </div>
                    
                    <div class="card-body">
                        <form method="post" action="<?= $config->site->url ?>/bms/http/events/new/" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="link" class="form-label">Link:</label>
                                <input type="url" class="form-control" id="link" name="link" required>
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">Date:</label>
                                <div class="d-flex align-items-center">
                                    <div class="date flex-1">
                                        <input type="text" class="form-control datepicker-date-today" id="date" name="date" value="<?= date('m/d/Y') ?>" required>
                                    </div>

                                    <div class="hour ms-1 position-relative">
                                        <label for="date" class="form-label position-absolute" style="top: -30px;">Time:</label>
                                        <select class="form-select" id="hour" name="hour">
                                            <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                <option value="<?= $i ?>"><?= $i ?></option>
                                            <?php endfor ?>
                                        </select>
                                    </div>

                                    <span class="separator mx-1">:</span>

                                    <div class="minute">
                                        <select class="form-select" id="minute" name="minute">
                                            <?php for ($i = 0; $i <= 59; $i++) : $minute = str_pad($i, 2, "0", STR_PAD_LEFT); ?>
                                                <option value="<?= $minute ?>"><?= $minute ?></option>
                                            <?php endfor ?>
                                        </select>
                                    </div>

                                    <div class="meridiem ms-1">
                                        <select class="form-select" id="meridiem" name="meridiem">
                                            <option value="am">AM</option>
                                            <option value="pm">PM</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Image:</label>
                                <img id="image-preview">
                                <input type="file" class="form-control" id="image" accept="image/png, image/jpeg, image/jpg, image/gif" name="image" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Add New Event</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                    <table class="table table-striped datatable-basic">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $event = new Core\Models\Event($connection);
                                $events = $event->getAll('*', ['orderBy' => ['id DESC']]);

                                foreach($events as $event) : ?>
                                    <tr>
                                        <td><?= $event['id'] ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <img width="50" style="height: 100%" src="<?= $config->site->url ?>/public/uploads/events/<?= $event['image'] ?>">

                                                <div class="image_actions">
                                                    <a href="<?= $config->site->url ?>/bms/events/edit/<?= $event['id'] ?>/">
                                                        <?= $event['title'] ?>
                                                    </a>
                                                    <div class="actions fs-sm fw-medium mt-1">
                                                        <!-- <a href="<?= $config->site->url ?>/bms/events/edit/<?= $event['id'] ?>/">Edit</a> <span class="text-muted fs-xs mx-1">|</span> -->
        
                                                        <a class="text-danger" href="<?= $config->site->url ?>/bms/http/events/delete/<?= $event['id'] ?>/" onclick="return confirm('You are about to permanently delete this event. This action cannot be undone. OK to delete?')">Delete</a> <span class="text-muted fs-xs mx-1">|</span>
        
                                                        <a href="<?= $event['link'] ?>" target="_blank">View</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><a href="<?= $event['link'] ?>"><?= $event['link'] ?></a></td>
                                        <td><?= Utility::formatDate($event['event_date'], 'm/d/Y \a\t h:i a'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /content area -->
    <script src="<?= $config->site->url; ?>/bms/assets/js/vendor/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('.datatable-basic').DataTable({
            columnDefs: [
                { "targets": 0, "visible": false }
            ],
            autoWidth: false,
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                emptyTable: 'No events found',
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '←' : '→', 'previous': document.dir == "rtl" ? '→' : '←' }
            }
        });
        table.order([0, 'desc']).draw();
    })
</script>

<script type="text/javascript" src="<?= $config->site->url; ?>/bms/assets/js/vendor/datepicker.min.js"></script>

<script> 
const dpTodayButtonElement = document.querySelector('.datepicker-date-today');
    if(dpTodayButtonElement) {
        const dpTodayButton = new Datepicker(dpTodayButtonElement, {
            container: '.content-inner',
            buttonClass: 'btn',
            prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
            nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
            todayBtn: true,
            autohide: true,
            todayBtnMode: 1,
            todayHighlight: true
        });
    }

    const fileInput = document.getElementById('image');
const imagePreview = document.getElementById('image-preview');

fileInput.addEventListener('change', function() {
  const file = this.files[0];
  const reader = new FileReader();

  reader.addEventListener('load', function() {
    imagePreview.src = reader.result;
    imagePreview.style.display = 'block';
  });

  imagePreview.style.display = 'none';
  reader.readAsDataURL(file);
});
</script>
<?php include __DIR__ . '/../includes/flash.php'; ?>
<?php include __DIR__ . '/../footer.php'; ?>