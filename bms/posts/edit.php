<?php 

use Core\Utility;

require_once __DIR__ . '/../../bootstrap.php';

$parent = 'posts/';
$file = 'posts/';
$page = 'Edit Post';

$postId = $_GET['post_id'] ?? null;

$postCategory = new Core\Models\PostCategory($connection);
$postTag = new Core\Models\PostTag($connection);
$tag = new Core\Models\Tag($connection);
$post = (new Core\Models\Post($connection, $postCategory, $postTag, $tag));

// Check that post exist
if (!$post->get('id', $postId)) {
    $flash->set('error', 'Invalid action');
    Utility::redirect($config->site->url . '/bms/posts/');
}

$post = $post->get('title, slug, content, author, created_at, featured_image', $postId);
$user = new Core\Models\User($connection);
$authors = $user->getAll();
$currentAuthor = $user->get('id', $post['author'])['id'];

include __DIR__ . '/../header.php';
?>

<style>
.ck.ck-content:not(.ck-comment__input *) {
    min-height: 350px;
    max-height: fit-content;
    height: auto;
    overflow: hidden;
}

.ck.ck-word-count {
    display: flex;
    gap: 10px;
    justify-content: end;
    margin-top: 7px;
}

#image-preview {
    display: none;
    max-width: 100%;
    margin-bottom: 0.5rem;
}
</style>

    <!-- Content area -->
    <div class="content pt-0">

        <form method="post" action="<?= $config->site->url ?>/bms/http/posts/edit/" class="position-relative" enctype="multipart/form-data">
            <input name="post_id" value="<?= $postId ?>" type="hidden">
            <div class="float-end position-absolute d-flex" style="margin-top:-48px;margin-bottom: 0.5rem;z-index:999;right:0;top:-12px;gap: 10px;">
                <a href="<?= $config->site->url ?>/bms/posts/" class="btn btn-light">Cancel</a>
                <a href="<?= $config->site->url ?>/bms/http/posts/trash/<?= $postId ?>/" class="btn btn-danger">Trash</a>
                <button type="submit" name="draft" class="btn btn-info">Save Draft</button>
                <button type="submit" name="publish" class="btn btn-primary">Publish</button>
            </div>
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" required autofocus value="<?= $post['title'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Content:</label>
                                <textarea rows="4" cols="3" class="form-control" id="content" name="content"><?= $post['content'] ?></textarea>
                                <div id="word-count" class="text-muted"></div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug:</label>
                                <input type="text" class="form-control" id="slug" name="slug" required value="<?= $post['slug'] ?>">
                            </div>

                            <!-- <div class="mb-3">
                                <label for="date" class="form-label">Date:</label>
                                <input type="text" class="form-control datepicker-date-today" id="date" name="date" value="<?= Utility::formatDate($post['created_at'], 'm/d/Y') ?>" required>
                            </div> -->

                            <div class="mb-3">
                                <label for="author" class="form-label">Author:</label>
                                <select class="form-control" id="author" name="author" required>
                                    <?php foreach ($authors as $author) : ?>
                                        <option <?= ($author['id'] == $currentAuthor) ? 'selected' : '' ?> value="<?= $author['id'] ?>"><?= $author['display_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <?php 
                                $category = new Core\Models\Category($connection); 
                                $cats = $category->getAll('id, name');
                                $currentCats = (new Core\Models\PostCategory($connection))->getAll('category_id', ['where' => ['post_id' => $postId]]);
                                ?>
                                <label for="categories" class="form-label">Categories:</label>
                                <input type="hidden" id="categories" name="categories" value="">
                                <select class="form-control multiselect" multiple="multiple">
                                <?php $currentCats = is_array($currentCats) ? $currentCats : [$currentCats]; ?>
                                <?php $currentCatIds = array_column($currentCats, 'category_id'); ?>
                                
                                <?php foreach ($cats as $cat): ?>
                                    <?php $selected = in_array($cat['id'], $currentCatIds); ?>
                                    <option value="<?= $cat['id'] ?>"<?= $selected ? ' selected' : '' ?>>
                                        <?= $cat['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags:</label>
                                <input type="text" class="form-control tokenfield-basic" id="tags">
                            </div>
                            
                            <div class="mb-3">
                                <label for="featured-image" class="form-label">Featured Image:</label>
                                <img id="image-preview" <?= (!empty($post['featured_image'])) ? "src=\"{$config->site->url}/public/uploads/posts/featured-images/{$post['featured_image']}\" style=\"display:block\"" : '' ?>>
                                <input type="file" class="form-control" id="featured-image" accept="image/png, image/jpeg, image/jpg, image/gif" name="featured-image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <!-- /content area -->

    <script src="<?= $config->site->url; ?>/bms/assets/js/vendor/ckeditor.js"></script>

<script>
const watchdog = new CKSource.EditorWatchdog();

window.watchdog = watchdog;
			
watchdog.setCreator( ( element, config ) => {
    return CKSource.Editor.create(document.querySelector('#content'),  {
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
        },
    })
    .then(editor => {
        const wordCountPlugin = editor.plugins.get('WordCount');
        const wordCountWrapper = document.getElementById('word-count');

        wordCountWrapper.appendChild( wordCountPlugin.wordCountContainer );
        
        return editor;
    })
});

watchdog.setDestructor(editor => {
    return editor.destroy();
});

watchdog.on('error', handleError);

watchdog.create(document.querySelector('#content'), {
    licenseKey: '',
})
.catch(handleError);

function handleError(error) {
    console.error('Oops, something went wrong!');
    console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
    console.warn('Build id: tskrc7m8az1-bugl64gbdfkm');
    console.error(error);
}			
</script>

<script src="<?= $config->site->url; ?>/bms/assets/js/bootstrap/bootstrap_multiselect.js"></script>
<script src="<?= $config->site->url; ?>/bms/assets/js/tokenfield.min.js"></script>
<script src="<?= $config->site->url; ?>/bms/assets/js/custom.js"></script>

<script> 
var TagInputs = function() {

var _componentTokenfield = function() {
    if (typeof Tokenfield == 'undefined') {
        console.warn('Warning - tokenfield.min.js is not loaded.');
        return;
    }

    <?php 

    // Fetch all tag IDs and their names
    $tags = $tag->getAll('id, name') ?: [];

    // Fetch the selected tags with their names
    $selectedTags = $postTag->getAll('tag_id, tags.name AS name', ['join' => ['', 'tags', 'tags.id = post_tags.tag_id'], 'where' => ['post_id' => $postId]]);
    $currentTags = $selectedTags ? array_map(function($tag) {
        return ['id' => $tag['tag_id'], 'name' => $tag['name']];
    }, $selectedTags) : [];

    $selectedTagsJSON = json_encode($currentTags);
    $tags = json_encode($tags);

    ?>

    // Tags prefill
    const tags = <?= $tags ?>;
    const selectedTags = <?= $selectedTagsJSON ?>

    // Basic initialization
    document.querySelectorAll('.tokenfield-basic').forEach(function(element) {
        const tfBasic = new Tokenfield({
            el: element,
            items: tags,
            setItems: selectedTags,
            addItemsOnPaste: true,
            delimiters: [',']
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

return {
    init: function() {
        _componentTokenfield();
    }
}
}();

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

<?php include __DIR__ . '/../includes/flash.php'; ?>
<?php include __DIR__ . '/../footer.php'; ?>