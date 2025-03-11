<?= $this->extend('layouts/public') ?>
<?= $this->section('content') ?>
<style>
    .pagination li{
        border-radius:2px;
        border:1px solid;
        padding:10px;
        list-style-type: none;
    }
    .pagination{
        list-style-type: none;
        text-decoration: none;

    }
    a{
        text-decoration: none;
        color: #333333;
    }
    .inline-list {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.inline-list li {
    display: inline-block;
    margin-right: 10px; /* Adjust as needed for spacing between items */
}
.inline-list li a {
    margin-right: 10px;
    width: 20px; /* Adjust as needed for spacing between items */
}
.highlight
{
    background-color: #EDEFF4;
}
</style>
<div class="row mb-3 mt-3">
    <div class="col-md-12">
        <h4 class="fw-bold">Brows by Name</h4>
        <p>
            Browse for your friends alphabetically by name.
            <br> Note: This only includes people who have Public Search Listings available on SocioOn.
        </p>
        <p>
       
        </p>    

    </div>
</div>
<div class="row">
    <div class="col-md-12">
    <ul class="nav nav-tabs" id="myTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link " id="tab1-tab" data-toggle="tab" href="<?= site_url('listings/people/a'); ?>" role="tab" aria-controls="tab1" aria-selected="true">Users </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" id="tab2-tab" data-toggle="tab" href="<?= site_url('listings/pages/a'); ?>" role="tab" aria-controls="tab2" aria-selected="false">Pages</a>
        </li>
        
    </ul>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
    <ul class="inline-list">
        <?php for ($i = 65; $i <= 90; $i++) : ?>
            <li><a href="<?= site_url('listings/pages/'.chr($i)); ?>" <?=(strtoupper($start_word)==chr($i))?  "style='border-bottom:4px solid;'":" "?>><b><?= chr($i) ?></b></a></li>
        <?php endfor; ?>
    </ul>
    </div>
</div>
<div class="row">
    <div class="col-md-12 highlight p-3 mt-2">
            <span> People Directory Resultys for "<?=strtoupper($start_word) ?>"</span>
    </div>
</div>
<div class="row">
    <?php $count = 0; ?>
    <?php foreach ($pages as $page) : ?>
        <?php if ($count % 3 == 0) : ?>
            </div><div class="row mt-2">
        <?php endif; ?>
        <div class="col-md-4">
           <a href="<?= site_url('pages/'.$page['page_username']) ?>" > <?= $page['page_title'] ?></a>
        </div>
        <?php $count++; ?>
    <?php endforeach; ?>
</div>

<?= $pager->links() ?>
<?= $this->endSection() ?>

