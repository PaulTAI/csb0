<?php $data = ($config["config"]["method"] == "POST") ? $_POST : $_GET; ?>

<form method="<?php echo $config["config"]["method"]; ?>" class="<?php echo $config["config"]["class"]; ?>" id="<?php echo $config["config"]["id"]; ?>">

    <?php if (!empty($config["errors"])) : ?>
        <div class="A-remplir">
            <ul>
                <?php foreach ($config["errors"] as $errors) : ?>
                    <li><?php echo $errors; ?></li>
                    <hr>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <?php if ($config["config"]["class"] == "A-remplir") : ?>

        <div class="A-remplir">

        <?php else : ?>

            <div class="A-remplir">

            <?php endif ?>

            <?php foreach ($config["data"] as $key => $value) : ?>

                <?php if ($value["type"] == "text" || $value["type"] == "email" || $value["type"] == "password" || $value["type"] == "number") : ?>

                    <?php if ($value["type"] == "password") unset($data[$key]); ?>

                    <div class="A-remplir">
                        <label class="A-remplir"><?php echo $value["placeholder"]; ?></label>
                        <input type="<?php echo $value["type"]; ?>" name="<?php echo $key; ?>" <?php echo ($value["required"]) ? 'required="required"' : ''; ?> id="<?php echo $value["id"]; ?>" class="<?php echo $value["class"]; ?>" <?php if (isset($value["value"])) : ?> value="<?php echo $data[$key] ?? $value["value"]; ?>" <?php else : ?> value="<?php echo $data[$key] ?? ''; ?>" <?php endif; ?> placeholder="<?php echo $value["placeholder"] ?>">
                    </div>

                <?php endif; ?>

            <?php endforeach; ?>

            </div>
            <div class="A-remplir">
                <input type="submit" class="A-remplir" value="<?php echo $config["config"]["submit"]; ?>">
            </div>
</form>