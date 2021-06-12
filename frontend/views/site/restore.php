<div style="    max-width: 267px;
    margin: auto;" class="site-error mt-5 text-center">
            <form action="/site/save-new-pass" method="POST" id="new_password" class="popup__form">
                <h3>Введите новый пароль</h3>
                <div class="form-input">
                    <input style="width: 80%" type="password" class="sizer" name="password" required placeholder="Новый пароль" >
                    <input type="hidden" name="token" value="<?php echo $token ?>">
                </div>
                <div class="form-input-submit">
                    <button type="submit">Сохранить</button>
                </div>
            </form>

</div>
