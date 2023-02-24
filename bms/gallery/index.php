<?php 

use Atlas\Query\Select;

require_once __DIR__ . '/../../bootstrap.php';

$parent = 'gallery/';
$file = $parent;
$page = 'Media Manager';

include __DIR__ . '/../header.php'; 
?>

<style>
    img {
        display: inline-block;
        margin: 10px;
        vertical-align: top;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
    }

    #progressBar {
        height: 5px;
        background-color: #ddd;
        margin: 0 10px;
        border-radius: 5px;
        overflow: hidden;
        display: none;
    }

    .progress {
        top: 50%;
        right: 50px;
        left: 50px;
    }

    .progress-bar {
        -webkit-transition: width 0.6s ease;
        transition: width 0.6s ease;
    }

    .card-img {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 255px;
    }

    #image-form {
        border: 2px dashed #ccc;
        padding: 20px;
        border-radius: 5px;
        text-align: center;
    }

    #image-form.dragover {
        border-color: #2196f3;
    }

    #image-form .form-label::before {
        content: ""; 
        font-family: "Phosphor";
        font-weight: bold;
        font-size: 16px;
        margin-right: 10px;
    }

    #image-form .form-control {
        display: inline-block;
        padding: 6px 12px;
        margin-bottom: 0;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    #image-form .form-control:focus {
        border-color: #66afe9;
        outline: 0;
    }

    .gallery_upload,
    #image-form .form-control::-webkit-file-upload-button {
        display: none;
    }

    #image-form .form-control::before {
        content: 'Select Images';
        display: inline-block;
        background-color: #f5f5f5;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 6px 12px;
        outline: none;
        white-space: nowrap;
        -webkit-user-select: none;
        cursor: pointer;
    }

    #image-form .form-control:hover::before {
        border-color: #999;
    }

    #image-form .form-control:active::before {
        background-color: #eee;
    }

    #image-form .form-label {
        margin-bottom: 10px;
        border: 1px solid var(--primary);
        font-size: 13px;
        min-height: 46px;
        padding: 0 36px;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 190px;
        margin: 0 auto;
        color: var(--white);
        background: var(--primary);
        cursor: pointer;
        border-radius: 4px;
    }

    #image-upload {
        display: none;
    }

    #image-upload::-webkit-file-upload-button {
        visibility: hidden;
    }

    #image-upload::before {
        content: 'Select Image(s)';
        display: inline-block;
        background: #007bff;
        color: #fff;
        padding: 0.375rem 0.75rem;
        border-radius: 0.25rem;
        outline: none;
        white-space: nowrap;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        cursor: pointer;
    }

    #image-upload:hover::before {
        background: #0062cc;
    }

    .overlay {
        background: rgba(0, 0, 0, 0.7);
        position: absolute;
        width: 100%;
        height: 100%;
        visibility: hidden;
    }

    .gallery-meta {
        visibility: hidden;
    }

    #image-preview .card-img-actions:hover > .overlay,
    #image-preview .card-img-actions:hover .gallery-meta {
        visibility: visible;
    }
</style>

<!-- Content area -->
<div class="content pt-0 position-relative">
    <div class="float-end position-absolute d-flex" style="margin-top:-48px;margin-bottom: 0.5rem;z-index:999;right:20px;top:-12px;gap: 10px;">
        <button id="add_new_image" class="btn btn-primary">Add New Image</button>
    </div>

    <div class="row mb-3 gallery_upload">
        <div class="col-lg-12">
            <form id="image-form" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <div class="fs-5 fw-bold text-muted mb-2">Drop Images to upload</div>
                    <p>or</p>
                    <label for="image-upload" class="form-label btn btn-primary">Select Image(s)</label>
                    <input type="file" id="image-upload" name="image-upload[]" multiple>
                    <p class="mt-4">Maximum upload file size: 8 MB.</p>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="image-preview" class="row">
                
                        <?php 
                        $gallery = new Core\Models\Gallery($connection);
                
                        // Set the limit of records per page
                        $limit = 12;
                
                        // Get the total number of records from your database or source
                        $total_records = $gallery->count()['count'];
                
                        // Calculate the total number of pages
                        $total_pages = ceil($total_records / $limit);
                
                        // Get the current page from the URL query parameter
                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                
                        // Calculate the offset for the current page
                        $offset = ($current_page - 1) * $limit;

                        $imageCount = $gallery->count()['count'];
                        
                        $images = Select::new($connection)
                            ->columns('*')
                            ->from('gallery')
                            ->limit($limit)
                            ->offset($offset)
                            ->orderBy('id DESC')
                            ->fetchAll();

                        if ($imageCount == 0) : ?>
                            <span class="">No image found in gallery</span>
                        <?php endif; ?>
                    
                        <?php foreach ($images as $image) : ?>
                            <div class="col-sm-6 col-xl-3 position-relative">
                                <div class="card">
                                    <div class="card-img-actions mx-1 my-1 position-relative">
                                        <div class="overlay"></div>
                                        <div class="card-img img-fluid" style="background-image: url(<?= $config->site->url . $image['image'] ?>)"></div>
                                        <div class="gallery-meta d-flex justify-content-center align-content-center position-absolute bottom-0 end-0 my-3 mx-3">
                                            <a onclick="return confirm('Deleting this image is permanent and can not be undone! OK to Delete?')" href="<?= $config->site->url ?>/bms/http/gallery/delete/<?= $image['id']; ?>/"><span class="ph-trash ph-2x text-danger"></span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($imageCount > $limit) : ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="pagination pagination-flat justify-content-center mt-4">
                                    <?php 
                                    $prev_link = ($current_page > 1) ? $config->site->url . "/bms/gallery/page/" . ($current_page - 1) : null;
                                    $next_link = ($current_page < $total_pages) ? $config->site->url . "/bms/gallery/page/" . ($current_page + 1) : null;
                                    ?>
                                    <li class="page-item <?= is_null($prev_link) ? 'disabled' : '' ?>">
                                        <a href="<?= $prev_link ?>" class="page-link rounded">←</a>
                                    </li>
                                    <?php for ($i = 1; $i <= $total_pages; $i++) :?>
                                        <li class="page-item <?= ($current_page == $i) ? 'active' : '' ?>">
                                            <a href="<?= $config->site->url . '/bms/gallery/page/' . $i . '/' ?>" class="page-link rounded"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?= is_null($next_link) ? 'disabled' : '' ?>">
                                        <a href="<?= $next_link ?>" class="page-link rounded">→</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /content area -->

<script>
$(document).ready(function() {
    // Handle file input changes
    $('#image-upload').on('change', function() {
        var files = $(this)[0].files;
        previewImages(files);
        uploadImages(files);
    });

    // Handle drag and drop events
    $(document).on('dragenter', function(e) {
        e.stopPropagation();
        e.preventDefault();
    });

    $(document).on('dragover', function(e) {
        e.stopPropagation();
        e.preventDefault();
    });

    $(document).on('drop', function(e) {
        e.stopPropagation();
        e.preventDefault();
        var files = e.originalEvent.dataTransfer.files;
        previewImages(files);
        uploadImages(files);
    });

    // Preview selected images
    function previewImages(files) {
        for (var i = 0; i < files.length; i++) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imageDiv = $('<div class="col-sm-6 col-xl-3 position-relative"></div>');
                var image = $('<div class="card"><div class="card-img-actions mx-1 my-1 position-relative"><div class="card-img img-fluid"></div><div class="progress position-absolute"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div></div></div>');
                imageDiv.append(image);
                $('#image-preview').prepend(imageDiv);
                image.find('.card-img').css('background-image', 'url(' + e.target.result + ')');
            }
            reader.readAsDataURL(files[i]);
        }
    }

    // Upload selected images
    function uploadImages(files) {
        for (var i = 0; i < files.length; i++) {
            var $preview = $($('#image-preview'));
            var form_data = new FormData();
            form_data.append('image-upload[]', files[i]);
                $.ajax({
                    url: '<?= $config->site->url ?>/bms/http/gallery/upload.php',
                    type: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        var xhr = new XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(e) {
                                var percent = Math.round((e.loaded / e.total) * 100);
                                $(this).find($('.progress-bar').width(percent + '%').attr('aria-valuenow', percent).text(percent + '%'));
                            
                        }.bind(this));
                        return xhr;
                    },
                    success: function(response) {
                        $preview.find('.progress').hide();
                        location.reload();
                    },
                    error: function(response) {
                        console.error(response);
                    }
                });
            }
        }
    });
</script>

<script>
    $(document).ready(function() {
        $("#add_new_image").click(function() {
            $(".gallery_upload").toggle();
        });

        $("#close_upload").click(function() {
            $(".gallery_upload").hide();
        });
    });
</script>

<?php include __DIR__ . '/../includes/flash.php'; ?>
<?php include __DIR__ . '/../footer.php'; ?>