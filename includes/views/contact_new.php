<div class="container contact-us-container">

    <div class="row">
        <div class="col-md-12">

            <div class="contact-us-section-heading">

                <div class="contact-us-header-wrapper">
                    <span><?=wfMessage('settlein-skin-project-page-contact-title')->plain()?></span>
                </div>

                <div class="contact-us-header-text-wrapper">
	                <?=wfMessage('settlein-skin-project-page-contact-title-text')->plain()?>
                </div>

            </div>

        </div>
    </div>

<div id="contactus-form">

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <form method="post" class="form-horizontal">

                <div class="form-group">
                    <label for="input-why" class="col-sm-2"><?=wfMessage('settlein-skin-project-page-contact-field-reason')->plain()?></label>
                    <div class="col-md-9 col-lg-8">
                        <select name="reason" id="input-why" class="form-control" required>
                            <option value="0" selected><?=wfMessage('settlein-skin-project-page-contact-field-reason-value-1')->plain()?></option>
                            <option value="1"><?=wfMessage('settlein-skin-project-page-contact-field-reason-value-2')->plain()?></option>
                            <option value="1"><?=wfMessage('settlein-skin-project-page-contact-field-reason-value-3')->plain()?></option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="input-name" class="col-sm-2"><?=wfMessage('settlein-skin-project-page-contact-field-name')->plain()?> <span class="text-danger">*</span> </label>
                    <div class="col-md-9 col-lg-8">
                        <input type="text" class="form-control" placeholder="" name="name" id="input-name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="input-email" class="col-sm-2"><?=wfMessage('settlein-skin-project-page-contact-field-email')->plain()?> <span class="text-danger">*</span> </label>
                    <div class="col-md-9 col-lg-8">
                        <input type="email" name="email" class="form-control" placeholder="" id="input-email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="input-message" class="col-sm-2"><?=wfMessage('settlein-skin-project-page-contact-field-message')->plain()?> <span class="text-danger">*</span></label>
                    <div class="col-md-9 col-lg-8">
                        <textarea class="form-control" rows="4" id="input-message" name="message" required></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary"><?=wfMessage('settlein-skin-project-page-contact-button-submit-title')->plain()?></button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>

</div>