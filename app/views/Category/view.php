<?php
/** @var $this View */
/** @var $category array */
/** @var $products array */
/** @var $total int */
/** @var $pagination object */
/** @var $breadcrumbs string */
use wfm\View;
?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <?= $breadcrumbs ?>
        </ol>
    </nav>
</div>

<div class="container py-3">
    <div class="row">

        <div class="col-lg-12 category-content">
            <h3 class="section-title"><?= $category['title'] ?></h3>

            <?php if (!empty($category['content'])): ?>
                <div class="category-desc">
                    <?= $category['content'] ?>
                </div>
                <hr>
            <?php endif; ?>

            <?php if ($pagination->countPages > 1 || count($products) > 1): ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="input-sort"><?php __('category_view_sort'); ?>:</label>
                            <select class="form-select" id="input-sort">
                                <option value=""><?php __('category_view_sort_by_default'); ?></option>
                                <option value="title_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'title_asc') echo 'selected'; ?>>
                                    <?php __('category_view_sort_title_asc'); ?>
                                </option>
                                <option value="title_desc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'title_desc') echo 'selected'; ?>>
                                    <?php __('category_view_sort_title_desc'); ?>
                                </option>
                                <option value="price_asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') echo 'selected'; ?>>
                                    <?php __('category_view_sort_price_asc'); ?>
                                </option>
                                <option value="price_desc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') echo 'selected'; ?>>
                                    <?php __('category_view_sort_price_desc'); ?>
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="input-limit">Показать:</label>
                            <select class="form-select" id="input-limit">
                                <option value="5" <?php if (isset($_GET['perpage']) && $_GET['perpage'] == 5) echo 'selected'; ?>>5</option>
                                <option value="10" <?php if (isset($_GET['perpage']) && $_GET['perpage'] == 10) echo 'selected'; ?>>10</option>
                                <option value="15" <?php if (isset($_GET['perpage']) && $_GET['perpage'] == 15) echo 'selected'; ?>>15</option>
                                <option value="20" <?php if (isset($_GET['perpage']) && $_GET['perpage'] == 20) echo 'selected'; ?>>20</option>
                                <option value="100" <?php if (isset($_GET['perpage']) && $_GET['perpage'] == 100) echo 'selected'; ?>>100</option>
                            </select>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php if (!empty($products)): ?>
                    <?php $this->getPart('parts/products_loop', compact('products')); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                <?= count($products) ?>
                                <?php __('tpl_total_pagination'); ?>
                                <?= $total ?>
                            </p>
                            <?php if ($pagination->countPages > 1): ?>
                                <?= $pagination ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <p><?php __('category_view_no_products'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

