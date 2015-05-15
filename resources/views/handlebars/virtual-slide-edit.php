<script id="virtual-slide-template" type="text/x-handlebars-template">
    <fieldset>
        <legend>Virtual slide</legend>
        <div class="form-group">
            <label class="control-label" for="url[]">Url</label>
            <input type="url" name="url[]" class="form-control" value=""/>
        </div>

        <div class="form-group">
            <label class="control-label" for="stain">Stain</label>
            <input name="stain[]" class="form-control" type="text" value=""/>
        </div>

        <div class="form-group">
            <a class="btn btn-primary remove-slide" href="#">Remove slide</a>
        </div>
    </fieldset>
</script>