<h3><?php echo $info['title']; ?></h3>
<b><a class="close" href="#"><i class="icon-remove-circle"></i></a></b>
<hr/>
<div><p id="msg_info"><i class="icon-info-sign"></i>&nbsp; Search existing users or add a new user.</p></div>
<div style="margin-bottom:10px;"><input type="text" class="search-input" style="width:100%;" placeholder="Search by email, phone or name" id="user-search"/></div>
<?php
if ($info['error']) {
    echo sprintf('<p id="msg_error">%s</p>', $info['error']);
} elseif ($info['msg']) {
    echo sprintf('<p id="msg_notice">%s</p>', $info['msg']);
} ?>
<div id="selected-user-info" style="display:<?php echo $user ? 'block' :'none'; ?>;margin:5px;">
<form method="get" class="user" action="#users/lookup">
    <input type="hidden" id="user-id" name="id" value="<?php echo $user ? $user->getId() : 0; ?>"/>
    <i class="icon-user icon-4x pull-left icon-border"></i>
    <a class="action-button pull-right" style="overflow:inherit"
        id="unselect-user"  href="#"><i class="icon-remove"></i> Add New User</a>
    <div><strong id="user-name"><?php echo $user ? $user->getName() : ''; ?></strong></div>
    <div>&lt;<span id="user-email"><?php echo $user ? $user->getEmail() : ''; ?></span>&gt;</div>
    <div class="clear"></div>
    <hr>
    <p class="full-width">
        <span class="buttons" style="float:left">
            <input type="button" name="cancel" class="close"  value="Cancel">
        </span>
        <span class="buttons" style="float:right">
            <input type="submit" value="Continue">
        </span>
     </p>
</form>
</div>
<div id="new-user-form" style="display:<?php echo $user ? 'none' :'block'; ?>;">
<form method="post" class="user" action="#users/lookup/form">
    <table width="100%">
    <?php
        if(!$form) $form = UserForm::getInstance();
        $form->render(true, 'Create New User'); ?>
    </table>
    <hr>
    <p class="full-width">
        <span class="buttons" style="float:left">
            <input type="reset" value="Reset">
            <input type="button" name="cancel" class="<?php echo $user ? 'cancel' : 'close' ?>"  value="Cancel">
        </span>
        <span class="buttons" style="float:right">
            <input type="submit" value="Add User">
        </span>
     </p>
</form>
</div>
<div class="clear"></div>
<script type="text/javascript">
$(function() {
    $('#user-search').typeahead({
        source: function (typeahead, query) {
            $.ajax({
                url: "ajax.php/users?q="+query,
                dataType: 'json',
                success: function (data) {
                    typeahead.process(data);
                }
            });
        },
        onselect: function (obj) {
            $('#user-name').text(obj.name);
            $('#user-email').text(obj.email);
            $('#user-id').val(obj.id);
            $('div#selected-user-info').show();
            $('div#new-user-form').hide();
            $('#user-search').val('');
        },
        property: "/bin/true"
    });

    $('a#unselect-user').click( function(e) {
        e.preventDefault();
        $('div#selected-user-info').hide();
        $('div#new-user-form').fadeIn();
        return false;
     });

    $(document).on('click', 'form.user input.cancel', function (e) {
        e.preventDefault();
        $('div#new-user-form').hide();
        $('div#selected-user-info').fadeIn();
        return false;
     });
});
</script>
