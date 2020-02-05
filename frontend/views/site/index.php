<?php

/* @var $this yii\web\View */

use yii\widgets\ActiveForm;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <?php
                if (!\Yii::$app->user->isGuest) {
                    $form = ActiveForm::begin();
                    echo $form->field($model, 'userId')->hiddenInput()->label(false);
                    echo \yii\helpers\Html::submitButton(\Yii::t('app', 'Push'), [
                        'class' => 'btn btn-default'
                    ]);
                    ActiveForm::end();
                } else {
                    echo \Yii::t('app', 'You must login');
                }
                ?>
            </div>
        </div>

    </div>
</div>
