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
        if ( !empty( $id ) ) {
            $this->event_id = $id;
        }
    }

    /**
     * Display event form
     *
     * @brief Display
     */
    public function display()
    {
        echo $this->html();
    }

    /**
     * Return the HTML markup for the event form
     *
     * @brief HTML markup event form
     *
     * @return string
     */
    public function html()
    {
        WPDKHTML::startCompress();
        ?>
        <div class="panel panel-default cems-event17-panel">
            <div class="panel-body">
                <form role="form" name="event17-form" id='event17-form' method="post" class="form-horizontal" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                      data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                      data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                    <input type="hidden" value="<?php echo $this->event_id;?>" name="eventId">
                    <input type="hidden" value="" name="customer_source">

                    <div class="form-group">
                        <label for="customer-email" class="col-sm-3 control-label"><?php echo __('
Địa chỉ email',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" id="customer-email" name="customer_email" placeholder="<?php echo __('Nhập địa chỉ email của bạn',WPCEMS_TEXTDOMAIN);?>" data-bv-notempty="true"
                                   data-bv-notempty-message="Bạn cần điền email"

                                   data-bv-emailaddress="true"
                                   data-bv-emailaddress-message="Email không hợp lệ">
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-default btn-check-exist" data-loading-text="Xin chờ ..." >Kiểm tra</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            Nếu bạn đã từng đăng ký với chúng tôi, bạn chỉ cần điền email, những thông tin khác sẽ được tự động điền giúp bạn.
                        </div>
                    </div>
                    <div class="alert alert-danger" role="alert" id="cems-notify-customer" style="display: none">
                        <div class="error-response"></div>
                    </div>
                    <div class="form-group">
                        <label for="customer-fullname" class="col-sm-3 control-label"><?php echo __('
Họ Tên',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="customer-fullname" name="customer_fullname" placeholder="<?php echo __('Nhập họ tên',WPCEMS_TEXTDOMAIN);?>" data-bv-notempty="true"
                                   data-bv-notempty-message="Họ tên không được để trống"

                                   data-bv-stringlength="true"
                                   data-bv-stringlength-min="3"
                                   data-bv-stringlength-max="255"
                                   data-bv-stringlength-message="Họ tên chỉ dài 3-255 ký tự">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customer-phone" class="col-sm-3 control-label"><?php echo __('
Số điện thoại',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                        <div class="col-sm-8">
                            <input type="tel" class="form-control" id="customer-phone" name="customer_phone" placeholder="<?php echo __('Nhập số điện thoại của bạn',WPCEMS_TEXTDOMAIN);?>" data-bv-notempty="true"
                                   data-bv-notempty-message="Không được để trống số điện thoại"

                                   data-bv-stringlength="true"
                                   data-bv-stringlength-min="6"
                                   data-bv-stringlength-max="15"
                                   data-bv-stringlength-message="Số điện thoại chỉ nằm trong 6-15 ký số"

                                   data-bv-regexp="true"
                                   data-bv-regexp-regexp="^[0-9]+$"
                                   data-bv-regexp-message="Số điện thoại chỉ gồm một chuỗi các số">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customer-birthday" class="col-sm-3 control-label">Ngày sinh<sup>*</sup></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="customer-birthday" name="customer_birthday" placeholder="DD-MM-YYYY"
                                   data-bv-notempty="true"
                                   data-bv-notempty-message="Bạn phải điền ngày sinh"

                                   data-bv-date="true"
                                   data-bv-date-format="DD-MM-YYYY"
                                   data-bv-date-message="Ngày sinh không hợp lệ"
                                   data-provide="datepicker"
                                   data-date-format="dd-mm-yyyy"
                                   data-date-language="vi"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Vì sao bạn biết đến buổi chia sẻ này<sup>*</sup></label>
                        <div class="col-sm-8">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="event_register_source" value="Facebook Life Coaching Vietnam"
                                           data-bv-notempty="true"
                                           data-bv-notempty-message="Bạn chưa chọn nguồn thông tin" /> Facebook Life Coaching Vietnam
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="event_register_source" value="Facebook bạn bè người thân chia sẻ" /> Facebook bạn bè người thân chia sẻ
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="event_register_source" value="Truyền miệng từ bạn bè người thân" /> Truyền miệng từ bạn bè người thân
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="event_register_source" value="Trang web lifecoach.com.vn" /> Trang web lifecoach.com.vn
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning" role="alert">
                        <strong>Ghi chú:</strong> Chúng tôi sẽ gửi thông tin đến địa chỉ email mà bạn đăng ký. Vui lòng nhập email chính xác.
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button data-loading-text="Đang gửi ..." type="submit" class="btn btn-primary" id="btn-new-customer" ><?php echo __('Xác nhận',WPCEMS_TEXTDOMAIN);?></button>
                            <button class="btn btn-default btn-reset"><?php echo __('Reset',WPCEMS_TEXTDOMAIN);?></button>
                        </div>
                    </div>					
					<div class="alert alert-danger alert-dismissible" role="alert" id="cems-alert" style="display: none">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Đóng</span>
						</button>
						<div class="error-response"></div>
					</div>
                </form>
            </div>
        </div>
        <?php
        $content = WPDKHTML::endHTMLCompress();
        return $content;
    }
}