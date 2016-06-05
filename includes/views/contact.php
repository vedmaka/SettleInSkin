<section>
    <div class="jumbotron">
        <div id="jumbo-about-backlay"></div>
        <div class="jumbo-content">

            <div class="i-jumbotext">
                <h1><?=wfMessage('settlein-skin-project-page-contact-title')->plain()?></h1>
                <p>
                    <?=wfMessage('settlein-skin-project-page-contact-title-text')->plain()?>
                </p>
            </div>

        </div>
</section>

<div class="container" id="contactus-items">

    <div class="row">
        <div class="col-md-4">
            <img src="holder.js/150x150" class="img-rounded" />
            <p><?=wfMessage('settlein-skin-project-page-contact-item-1-text')->plain()?></p>
        </div>
        <div class="col-md-4">
            <img src="holder.js/150x150" class="img-rounded" />
            <p><?=wfMessage('settlein-skin-project-page-contact-item-2-text')->plain()?></p>
        </div>
        <div class="col-md-4">
            <img src="holder.js/150x150" class="img-rounded" />
            <p><?=wfMessage('settlein-skin-project-page-contact-item-3-text')->plain()?></p>
        </div>
    </div>

</div>

<div class="container" id="contactus-form">

    <div class="row">
        <div class="col-sm-10 col-lg-offset-1">
            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <label for="input-name" class="col-sm-2"><?=wfMessage('settlein-skin-project-page-contact-field-name')->plain()?></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="" name="name" id="input-name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-email" class="col-sm-2"><?=wfMessage('settlein-skin-project-page-contact-field-email')->plain()?> <span class="text-danger">*</span> </label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" placeholder="" id="input-email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-message" class="col-sm-2"><?=wfMessage('settlein-skin-project-page-contact-field-message')->plain()?> <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="4" id="input-message" name="message" required></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="input-why" class="col-sm-2"><?=wfMessage('settlein-skin-project-page-contact-field-reason')->plain()?></label>
                    <div class="col-sm-10">
                        <select name="reason" id="input-why" class="form-control" required>
                            <option value="0" selected><?=wfMessage('settlein-skin-project-page-contact-field-reason-value-1')->plain()?></option>
                            <option value="1"><?=wfMessage('settlein-skin-project-page-contact-field-reason-value-2')->plain()?></option>
                            <option value="1"><?=wfMessage('settlein-skin-project-page-contact-field-reason-value-3')->plain()?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary"><?=wfMessage('settlein-skin-project-page-contact-button-submit-title')->plain()?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>