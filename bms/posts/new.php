<?php 

$parent = 'posts/';
$file = 'posts/new/';
$page = 'Add New Post';

include __DIR__ . '/../header.php'; 
?>

<style>
.ck.ck-content:not(.ck-comment__input *) {
    height: 350px;
    overflow-y: auto;
}

#image-preview {
    display: none;
    max-width: 100%;
    margin-bottom: 0.5rem;
}
</style>

    <!-- Content area -->
    <div class="content pt-0">

        <form method="post" action="<?= $config->site->url ?>/bms/http/posts/new/" class="position-relative">
            <div class="float-end position-absolute d-flex" style="margin-top:-48px;margin-bottom: 0.5rem;z-index:999;right:0;top:-12px;gap: 10px;">
                <button type="submit" name="draft" class="btn btn-light">Save Draft</button>
                <button type="submit" name="publish" class="btn btn-primary">Publish</button>
            </div>
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Content:</label>
                                <textarea rows="4" cols="3" class="form-control" id="content" name="content"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug:</label>
                                <input type="text" class="form-control" id="slug" name="slug" required>
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">Date:</label>
                                <input type="text" class="form-control datepicker-date-today" id="date" name="date" value="<?= date('m/d/Y') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="author" class="form-label">Author:</label>
                                <select class="form-control" id="author" name="author" required>
                                    <option value="1">Author 1</option>
                                    <option value="2">Author 2</option>
                                    <option value="3">Author 3</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="categories" class="form-label">Categories:</label>
                                <input type="hidden" id="categories" name="categories" value="">
                                <select class="form-control multiselect" multiple="multiple">
                                    <option value="cheese" selected>Cheese</option>
                                    <option value="tomatoes">Tomatoes</option>
                                    <option value="mozarella">Mozzarella</option>
                                    <option value="mushrooms">Mushrooms</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags:</label>
                                <input type="text" class="form-control tokenfield-basic" id="tags">
                            </div>
                            
                            <div class="mb-3">
                                <label for="featured-image" class="form-label">Featured Image:</label>
                                <img id="image-preview">
                                <input type="file" class="form-control" id="featured-image" accept="image/png, image/jpeg, image/jpg, image/gif" name="featured-image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <?php 
        // $date = DateTime::createFromFormat('m/d/Y', date('m/d/Y'));
        // echo $date->format('Y-m-d h:i:s');
        ?>

    </div>
    <!-- /content area -->

<script src="<?= $config->site->url; ?>/bms/assets/js/vendor/editors/ckeditor/ckeditor_classic.js"></script>

<script> 
// Editor with prefilled text
ClassicEditor.create(document.querySelector('#content'), {
    heading: {
        options: [
            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
            { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
            { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
            { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
        ]
    }
}).catch(error => {
	console.error(error);
});
</script>

<script>
// Make Strings URL-safe
function slug(text) {
    return text.toString().toLowerCase()
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
}

document.addEventListener('DOMContentLoaded', function() {
  const titleInput = document.querySelector('input[name="title"]');
  const slugInput = document.querySelector('input[name="slug"]');

  titleInput.addEventListener('keyup', function() {
    slugInput.value = slug(titleInput.value);
  });
});
</script>

<script src="<?= $config->site->url; ?>/bms/assets/js/bootstrap/bootstrap_multiselect.js"></script>
<script src="<?= $config->site->url; ?>/bms/assets/js/tokenfield.min.js"></script>
<script src="<?= $config->site->url; ?>/bms/assets/js/custom.js"></script>

<script> 
// Setup module
// ------------------------------

var TagInputs = function() {


//
// Setup module components
//

// Tokenfield
var _componentTokenfield = function() {
    if (typeof Tokenfield == 'undefined') {
        console.warn('Warning - tokenfield.min.js is not loaded.');
        return;
    }

    // Demo data
    const cars = [
        {id: 1, name: "Acura"},
        {id: 2, name: "Audi"},
        {id: 3, name: "BMW"},
        {id: 4, name: "Buick"},
        {id: 5, name: "Cadillac"},
        {id: 6, name: "Chevrolet"},
        {id: 7, name: "Chrysler"},
        {id: 8, name: "Citroen"},
        {id: 9, name: "Dodge"},
        {id: 10, name: "Eagle"},
        {id: 11, name: "Ferrari"},
        {id: 12, name: "Ford"},
        {id: 13, name: "General Motors"},
        {id: 14, name: "GMC"},
        {id: 15, name: "Honda"},
        {id: 16, name: "Hummer"},
        {id: 17, name: "Hyundai"},
        {id: 18, name: "Infiniti"},
        {id: 19, name: "Isuzu"},
        {id: 20, name: "Jaguar"},
        {id: 21, name: "Jeep"},
        {id: 22, name: "Kia"},
        {id: 23, name: "Lamborghini"},
        {id: 24, name: "Land Rover"},
        {id: 25, name: "Lexus"},
        {id: 26, name: "Lincoln"},
        {id: 27, name: "Lotus"},
        {id: 28, name: "Mazda"},
        {id: 29, name: "Mercedes-Benz"},
        {id: 30, name: "Mercury"},
        {id: 31, name: "Mitsubishi"},
        {id: 32, name: "Nissan"},
        {id: 33, name: "Oldsmobile"},
        {id: 34, name: "Peugeot"},
        {id: 35, name: "Pontiac"},
        {id: 36, name: "Porsche"},
        {id: 37, name: "Regal"},
        {id: 38, name: "Renault"},
        {id: 39, name: "Saab"},
        {id: 40, name: "Saturn"},
        {id: 41, name: "Seat"},
        {id: 42, name: "Skoda"},
        {id: 43, name: "Subaru"},
        {id: 44, name: "Suzuki"},
        {id: 45, name: "Toyota"},
        {id: 46, name: "Volkswagen"},
        {id: 47, name: "Volvo"}
    ];


    // Basic initialization
    document.querySelectorAll('.tokenfield-basic').forEach(function(element) {
        const tfBasic = new Tokenfield({
            el: element,
            items: cars
        });
    });

    tfRemoteRemap.remapData = function(response) {
    console.log('bar');
        return response;
    }
    tfRemoteRemap.renderSetItemLabel = function(item) {
        return item.name.toUpperCase();
    }
};

//
// Return objects assigned to module
//

return {
    init: function() {
        _componentTokenfield();
    }
}
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
TagInputs.init();
});

const fileInput = document.getElementById('featured-image');
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

<script type="text/javascript" src="<?= $config->site->url; ?>/bms/assets/js/vendor/datepicker.min.js"></script>

<script> 
// Basic initialization
const dpTodayButtonElement = document.querySelector('.datepicker-date-today');
    if(dpTodayButtonElement) {
        const dpTodayButton = new Datepicker(dpTodayButtonElement, {
            container: '.content-inner',
            buttonClass: 'btn',
            prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
            nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
            todayBtn: true
        });
    }
</script>
<?php include __DIR__ . '/../footer.php'; ?>