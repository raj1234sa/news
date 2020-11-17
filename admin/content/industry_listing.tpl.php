<div class="page-header">
    <h1>
        <?php echo $pageTitle;?>
    </h1>
    <?php echo draw_action_buttons($action_buttons) ?>
</div><!-- /.page-header -->

<div class="table-responsive">
    <table id="dataTable" class="ajax table">
        <thead>
            <tr>
                <th class="text-center">Sr No</th>
                <th>Industry Name</th>
                <th class="text-center" data-default-sort='true' data-sort-dir='asc'>Sort Order</th>
                <th class="text-center">Status</th>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th data-printhide='true' data-order='false'>Action</th>
            </tr>
        </thead>
    </table>
</div>

<script>
    var tabletools = ['print','export'];
</script>