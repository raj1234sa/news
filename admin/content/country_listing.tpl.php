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
                <th>Country Name</th>
                <th class="text-center">Status</th>
                <th data-printhide='true' data-order='false'>Action</th>
            </tr>
        </thead>
    </table>
</div>

<script>
    var tabletools = ['print','export'];
</script>