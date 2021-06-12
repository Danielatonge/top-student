<?php
/**
 * @var yii\web\View $this
 * @var string $content
 */

use yii\helpers\ArrayHelper;
use yii\bootstrap4\Breadcrumbs;

$this->beginContent('@frontend/views/layouts/base.php')
?>

    <?php echo $content ?>
<?php $this->endContent() ?>
