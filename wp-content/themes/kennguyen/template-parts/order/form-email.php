<?php
if (check_membership() != 1) {
    echo '<div class="form_submit pt-20 text-center">
                                        <form method="post" class="submit-form-email">
                                            <input class="input" name="guest_email" type="text" placeholder="Your Email Adress"/>
                                            <input class="submit" type="submit" name="submit-form-guest-email" value="JOIN NOW" id="submit-guest-email"/>
                                        </form>
                                        <div class="spinner-border submit-loading-email mt-10 ml-4" role="status" style="display: none"></div>
                                    </div>';
}
?>
