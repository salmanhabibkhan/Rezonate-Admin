<?= $this->extend('admin/_layouts/_layouts') ?>
<?= $this->section('content') ?>

<?= $this->include('admin/_partials/breadcrumb/breadcrumb') ?>

<section class="content">
    <div class="container-fluid">

        <div class="row">

            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Political News</h3><br>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                             <a href="<?=base_url('admin/political-news/create')?>" class="btn btn-success btn-sm mb-3 float-right"><i class="fa fa-plus mr-2 text-light"></i> Add News </a>
                                <div class="table-responsive">
                                    <table class="cisocial_table table table-bordered table-striped ">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>title</th>
                                                <th>Attachment</th>
                                                
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($politicalnews as $key=> $news) : ?>
                                                <tr>
                                                    <td><?= ++$key?> </td>
                                                    <td><?= $news['title'] ?></td>
                                                    <td><img width="20" class="rounded-circle mr-2" height="20" src="<?=getMedia($news['attachment'],);?>" ></td>
                                                   
                                                    
                                                   
                                                    <td>
                                                    <div class="dropdown" style="display: inline;">
                                                        <svg style="cursor: pointer;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                                                        <div class="dropdown-menu dropdown-menu-right" role="menu" x-placement="top-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-167px, -79px, 0px);" x-out-of-boundaries="">
                                                            <!-- <a class="dropdown-item" href="javascript:void(0)" onclick="getUserId(254379);" data-toggle="modal" data-target="#FollowersForm">Add Followers</a> -->
                                                          
                                                            <a class="dropdown-item"  href="<?=base_url('admin/political-news/edit/'.$news['id'])?>">Edit</a>
                                                            <a class="dropdown-item" href="<?= base_url('admin/political-news/delete/'.$news['id']) ?>" onclick="return confirm('Are you sure?')">Delete</a>
                                                            
                                                        </div>
                                                    </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                
                            <?php if ($pager) :?>
                                    <?php 
                                    $pagination = $pager->links();

                                    // Add Bootstrap Pagination Class
                                    $pagination = str_replace('<a', '<a class="page-link"', $pagination);
                                    $pagination = str_replace('<ul>', '<ul class="pagination"', $pagination);
                                    $pagination = str_replace('<li', '<li class="page-item"', $pagination);
                                    $pagination = str_replace('span', 'a', $pagination);
                                    $pagination = str_replace('Previous', '&laquo;', $pagination);
                                    $pagination = str_replace('Next', '&raquo;', $pagination);

                                    // Highlight the active page
                                    $currentPage = $pager->getCurrentPage();
                                    $pagination = preg_replace('/<li class="page-item"><a class="page-link" href="#">' . $currentPage . '<\/a><\/li>/', '<li class="page-item active"><a class="page-link" href="#">' . $currentPage . '</a></li>', $pagination);

                                    echo $pagination;
                                    ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?= $this->endSection() ?>

<?= $this->section('script') ?>
<?= $this->include('admin/script') ?>


<?= $this->endSection() ?>