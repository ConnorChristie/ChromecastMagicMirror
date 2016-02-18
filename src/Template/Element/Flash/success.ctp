<div class="alert alert-dismissible alert-success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>

    <?php
    if (is_array($message) && isset($message['title']) && isset($message['body'])) {
        echo '<h4><strong>' . h($message['title']) . '</strong></h4>' . h($message['body']);
    } else if (!is_array($message)) {
        echo h($message);
    }
    ?>
</div>
