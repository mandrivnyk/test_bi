<div id="container">
    <h1>Welcome!</h1>
    <div id="body">
        <?php echo $error;?>
        <?php echo form_open_multipart('test/do_upload');?>
        <input type="file" name="userfile" size="20" />
        <input type="submit" value="upload" />
        </form>
    </div>
</div>
<br />
