<?php
/**
 * Created by PhpStorm.
 * User: pnghai
 * Date: 7/9/14
 * Time: 1:09 PM
 */
/**
 * Model of a single CEMSPreviewEbook template
 *
 * @class           CEMSPreviewEbook
 * @author          pnghai <nguyenhai@siliconstraits.vn>
 * @copyright       Copyright (C) 2014-2015 Silicon Straits. All Rights Reserved.
 * @date            2014-07-15
 * @version         1.0.0
 *
 */
class CEMSPreviewEbook {

    /**
     * List ID
     *
     * @brief List ID
     *
     * @var int $list_id
     */
    public $list_id = -1;

    /**
     * Book Title
     *
     * @brief Book Title
     *
     * @var int $book_title
     */
    public $book_title = '';

    /**
     * Create an instance of CEMSPreviewEbook class
     *
     * @brief Construct
     *
     * @param array Required Shortcode Attributes
     *
     * @return CEMSPreviewEbook
     */
    public function __construct( $attributes)
    {
        extract($attributes);
        if ( !empty( $list_id ) ) {
            $this->list_id=$list_id;
        }
        if ( !empty( $book_title ) ) {
            $this->book_title=$book_title;
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
        <div class="panel panel-default cems-preview-ebook-panel">
            <div class="panel-body">
                <button type="button" class="center-block btn btn-primary" data-toggle="collapse" data-target="#ebook-subscription">
                    Tải về và đọc thử sách <?php echo $this->book_title;?> (giống sách in 100%)
                </button>
                <p></p>
                <div id="ebook-subscription" class="collapse">
                    <p>Bạn đã đăng ký email để tải thông tin trên trang TGM Books chưa?</p>
                    <div id="cems-alerts"></div>
                    <div class="panel-group" id="cems-accordion1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#cems-accordion1" href="#collapseSubscriptionForm">
                                        <?php echo __('Tôi đã đăng ký email',WPCEMS_TEXTDOMAIN);?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseSubscriptionForm" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <form role="form" class="form-inline" name="subscription-form" id="subscription-form" method="post" >
                                        <div class="alert alert-info" role="alert"><?php echo __('Vui lòng nhập lại địa chỉ email bạn đã đăng ký',WPCEMS_TEXTDOMAIN);?></div>
                                        <div class="form-group">
                                            <label for="subscription-email"><?php echo __('
Địa chỉ email của bạn',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                                            <input type="email" class="form-control" id="subscription-email" name="subscriptionEmail" placeholder="<?php echo __('Nhập địa chỉ email',WPCEMS_TEXTDOMAIN);?>" required>
                                            <input type="hidden" class="hidden" name="listId" value="<?php echo $this->list_id;?>"/>
                                        </div>
                                        <button data-loading-text="Đang gửi ..." type="submit" class="btn btn-primary" id="btn-new-subscription"><?php echo __('Xác nhận',WPCEMS_TEXTDOMAIN);?></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#cems-accordion1" href="#collapseCustomerForm">
                                        <?php echo __('Tôi chưa đăng ký email',WPCEMS_TEXTDOMAIN);?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseCustomerForm" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <form role="form" name="customer-form" id='customer-form' method="post" class="form-horizontal">
                                        <div class="form-group">
                                            <label for="customer-name" class="col-sm-3 control-label"><?php echo __('
Họ tên',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="customer-name" name="customerName" placeholder="<?php echo __('Nhập họ và tên',WPCEMS_TEXTDOMAIN);?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer-province" class="col-sm-3 control-label"><?php echo __('
Tỉnh thành',WPCEMS_TEXTDOMAIN);?></label>
                                            <div class="col-sm-9">
                                                <select class="chosen-select" id="customer-province" name="customerProvince">
                                                     <option value="1">An Giang</option><option value="2">Bà Rịa - Vũng Tàu</option><option value="4">Bắc Cạn</option><option value="5">Bắc Giang</option><option value="3">Bạc Liêu</option><option value="6">Bắc Ninh</option><option value="7">Bến Tre</option><option value="8">Bình Dương</option><option value="9">Bình Định</option><option value="10">Bình Phước</option><option value="11">Bình Thuận</option><option value="12">Cà Mau</option><option value="14">Cần Thơ</option><option value="13">Cao Bằng</option><option value="15">Đà Nẵng</option><option value="16">Đắk Lắk</option><option value="17">Đắk Nông</option><option value="18">Điện Biên</option><option value="19">Đồng Nai</option><option value="20">Đồng Tháp</option><option value="21">Gia Lai</option><option value="22">Hà Giang</option><option value="23">Hà Nam</option><option value="24">Hà Nội</option><option value="26">Hà Tĩnh</option><option value="27">Hải Dương</option><option value="28">Hải Phòng</option><option value="29">Hậu Giang</option><option value="31" selected="selected">Hồ Chí Minh</option><option value="30">Hòa Bình</option><option value="32">Hưng Yên</option><option value="33">Khánh Hoà</option><option value="34">Kiên Giang</option><option value="35">Kon Tum</option><option value="36">Lai Châu</option><option value="39">Lâm Đồng</option><option value="37">Lạng Sơn</option><option value="38">Lào Cai</option><option value="40">Long An</option><option value="41">Nam Định</option><option value="42">Nghệ An</option><option value="43">Ninh Bình</option><option value="44">Ninh Thuận</option><option value="45">Phú Thọ</option><option value="46">Phú Yên</option><option value="47">Quảng Bình</option><option value="48">Quảng Nam</option><option value="49">Quảng Ngãi</option><option value="50">Quảng Ninh</option><option value="51">Quảng Trị</option><option value="52">Sóc Trăng</option><option value="53">Sơn La</option><option value="54">Tây Ninh</option><option value="55">Thái Bình</option><option value="56">Thái Nguyên</option><option value="57">Thanh Hoá</option><option value="58">Thừa Thiên - Huế</option><option value="59">Tiền Giang</option><option value="60">Trà Vinh</option><option value="61">Tuyên Quang</option><option value="62">Vĩnh Long</option><option value="63">Vĩnh Phúc</option><option value="64">Yên Bái</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer-email" class="col-sm-3 control-label"><?php echo __('
Địa chỉ email',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" id="customer-email" name="customerEmail" placeholder="<?php echo __('Nhập địa chỉ email của bạn',WPCEMS_TEXTDOMAIN);?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer-phone" class="col-sm-3 control-label"><?php echo __('
Số điện thoại',WPCEMS_TEXTDOMAIN);?><sup>*</sup></label>
                                            <div class="col-sm-9">
                                                <input type="tel" class="form-control" id="customer-phone" name="customerPhone" placeholder="<?php echo __('Nhập số điện thoại của bạn',WPCEMS_TEXTDOMAIN);?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer-reading" class="col-sm-5">Bạn thích đọc loại sách nào?  <p class="help-block">(có thể chọn nhiều loại)</p></label>
                                            <div class="col-sm-7 checkbox" id="customer-reading">
                                                    <label for="customer-reading-1">
                                                        <input id="customer-reading-1" type="checkbox" class="loaisach" name="customerReading[]" value="1">Phát triển bản thân và kỹ năng.
                                                    </label>
                                                    <label for="customer-reading-2">
                                                        <input id="customer-reading-2" type="checkbox" class="loaisach" name="customerReading[]" value="2">Kinh doanh &amp; đầu tư
                                                    </label>
                                                    <label for="customer-reading-3">
                                                        <input id="customer-reading-3" type="checkbox" class="loaisach" name="customerReading[]" value="3">Các mối quan hệ gia đình và con cái.
                                                    </label>
                                            </div>
                                        </div>
                                        <div class="alert alert-warning" role="alert">
                                            <strong>Ghi chú:</strong> Chúng tôi sẽ gửi thông tin đến địa chỉ email mà bạn đăng ký. Vui lòng nhập email chính xác.
                                        </div>
                                        <input type="hidden" class="hidden" name="listId" value="<?php echo $this->list_id;?>"/>
                                        <div class="form-group">
                                            <div class="col-sm-2 col-sm-offset-5">
                                                <button data-loading-text="Đang gửi ..." type="submit" class="center-block btn btn-primary" id="btn-new-customer"><?php echo __('Xác nhận',WPCEMS_TEXTDOMAIN);?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $content = WPDKHTML::endHTMLCompress();
        return $content;
    }
}