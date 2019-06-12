<div class="adminRightHeader"><?php echo _("EBSCO Knowledge Base Configuration");?></div>
<form id="ebscoKbConfig">
    <div id="ebscoKbConfigError" class="darkRedText greyCyan" ></div>
    <div class="450 margin100">
        <label for="ebscoKbEnabled">
            <input type="checkbox" name="enabled" id="ebscoKbEnabled" value="true" <?php echo $config->settings->ebscoKbEnabled == 'Y' ? 'checked' : ''; ?>>
            <?php echo _("Enable EBSCO Knowledge Base"); ?>
        </label>
    </div>
    <div class="160 marginR20 InlineB">
        <label for="ebscoKbCustomerId" class="displayB">Customer ID</label>
        <input type="text" name="customerId" value="<?php echo $config->settings->ebscoKbCustomerId; ?>" id="ebscoKbCustomerId">
    </div>
    <div class="260 InlineB">
        <label for="ebscoKbApiKey" class="displayB">Api Key</label>
        <input type="text" name="apiKey" value="<?php echo $config->settings->ebscoKbApiKey; ?>" id="ebscoKbApiKey" class="wHundred">
    </div>
    <div class="marginT10">
        <button class="btn btn-primary" type="submit" >Save</button>
    </div>
</form>
