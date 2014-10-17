<?php
/**
 * Created by PhpStorm.
 * User: pnghai
 * Date: 7/9/14
 * Time: 1:09 PM
 */
/**
 * Model of a single CEMSEvent17 template
 *
 * @class           CEMSEvent17
 * @author          pnghai <nguyenhai@siliconstraits.vn>
 * @copyright       Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date            2014-10-15
 * @version         1.0.0
 *
 */
class CEMSEvent17 {

    /**
     * Event ID
     *
     * @brief Event ID
     *
     * @var int $event_id
     */
    public $event_id = -1;

    /**
     * Create an instance of CEMSEvent17 class
     *
     * @brief Construct
     *
     * @param array $attributes Required Shortcode Attributes
     *
     * @return CEMSEvent17
     */
    public function __construct( $attributes)
    {
        extract($attributes);
        if ( !empty( $event_id ) ) {
            $this->event_id=$event_id;
        }
    }

    /**
     * Display preview button
     *
     * @brief Display
     */
    public function display()
    {
        echo $this->html();
    }

    /**
     * Return the HTML markup for the preview button
     *
     * @brief HTML markup preview button
     *
     * @return string
     */
    public function html()
    {
        WPDKHTML::startCompress();
        //#TODO: Bootstrap things come with CEMSTheme should only loaded here
        ?>
        <div class="panel panel-default cems-event17-panel">
            <div class="panel-body">
                <div id="ebook-subscription" class="collapse">
                    <div class="alert alert-danger alert-dismissible" role="alert" id="cems-alert" style="display: none">
                        <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Đóng</span>
                        </button>
                        <div class="error-response"></div>
                    </div>
                </div>
                <form role="form" name="event17-form" id='event17-form' method="post" class="form-horizontal" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                      data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                      data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    <input type="hidden" value="<?php echo $this->eventId;?>" name="eventId">
                    <input type="hidden" value="" name="customer_source">

                    <div class="form-group">
                        <label for="customer-email" class="col-sm-3 control-label"><?php echo __('
Địa chỉ email',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="customer-email" name="customerEmail" placeholder="<?php echo __('Nhập địa chỉ email của bạn',WPCEMS_TEXTDOMAIN);?>" data-bv-notempty="true"
                                   data-bv-notempty-message="The email address is required and cannot be empty"

                                   data-bv-emailaddress="true"
                                   data-bv-emailaddress-message="The email address is not a valid">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customer-fullname" class="col-sm-3 control-label"><?php echo __('
Họ Tên',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="customer-fullname" name="customerFullName" placeholder="<?php echo __('Nhập họ',WPCEMS_TEXTDOMAIN);?>" data-bv-notempty="true"
                                   data-bv-notempty-message="The full name is required and cannot be empty"

                                   data-bv-stringlength="true"
                                   data-bv-stringlength-min="6"
                                   data-bv-stringlength-max="30"
                                   data-bv-stringlength-message="The full name must be more than 6 and less than 30 characters long"

                                   data-bv-regexp="true"
                                   data-bv-regexp-regexp="^[a-zA-Z0-9]+$"
                                   data-bv-regexp-message="The username can only consist of alphabetical and number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customer-phone" class="col-sm-3 control-label"><?php echo __('
Số điện thoại',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                        <div class="col-sm-8">
                            <input type="tel" class="form-control" id="customer-phone" name="customerPhone" placeholder="<?php echo __('Nhập số điện thoại của bạn',WPCEMS_TEXTDOMAIN);?>" data-bv-notempty="true"
                                   data-bv-notempty-message="The username is required and cannot be empty">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Date of birth</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="birthday" placeholder="DD-MM-YYYY"
                                   data-bv-notempty="true"
                                   data-bv-notempty-message="The date of birth is required"

                                   data-bv-date="true"
                                   data-bv-date-format="DD-MM-YYYY"
                                   data-bv-date-message="The date of birth is not valid"
                                   data-provide="datepicker"
                                   data-date-format="dd-mm-yyyy"
                                   data-date-language="vi"
                                   data-date-autoclose="true"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Vì sao bạn biết đến buổi chia sẻ này</label>
                        <div class="col-sm-5">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="source" value="male"
                                           data-bv-notempty="true"
                                           data-bv-notempty-message="The gender is required" /> Facebook Life Coaching Vietnam
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="source" value="female" /> Facebook bạn bè người thân chia sẻ
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="source" value="female" /> Truyền miệng từ bạn bè người thân
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="source" value="other" /> Trang web lifecoach.com.vn
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning" role="alert">
                        <strong>Ghi chú:</strong> Chúng tôi sẽ gửi thông tin đến địa chỉ email mà bạn đăng ký. Vui lòng nhập email chính xác.
                    </div>
                    <div class="form-group">
                        <div class="center-block">
                            <button data-loading-text="Đang gửi ..." type="submit" class="center-block btn btn-primary" id="btn-new-customer"><?php echo __('Xác nhận',WPCEMS_TEXTDOMAIN);?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
        $content = WPDKHTML::endHTMLCompress();
        return $content;
    }
}