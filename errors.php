<?php if (count($errors) > 0): ?>
    <div class="errors">
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif ?>