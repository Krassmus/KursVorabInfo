<form action="<?= PluginEngine::getLink($plugin, array(), "splash/edit") ?>"
      method="post"
      class="default">

    <label>
        <?= _("Überschrift") ?>
        <input type="text" name="splash_title" value="<?= htmlReady(CourseConfig::get(Context::get()->id)->KURSVORABINFO_TITLE ?: _("Erklärung")) ?>">
    </label>

    <label>
        <?= _("Vorabinformation") ?>
        <textarea name="splash_info" class="add_toolbar wysiwyg"><?= formatReady(CourseConfig::get(Context::get()->id)->KURSVORABINFO_INFO) ?></textarea>
    </label>

    <div data-dialog-button>
        <?= \Studip\Button::create(_("Speichern"), "save") ?>
        <?= \Studip\Button::create(_("Löschen"), "delete") ?>
    </div>
</form>