<?php

class SplashController extends PluginController
{
    public function edit_action()
    {
        if (!$GLOBALS['perm']->have_studip_perm("tutor", Context::get()->id)) {
            throw new AccessDeniedException();
        }
        Navigation::activateItem("/course/admin/splash");
        PageLayout::setTitle(_("Eingangsinformationen"));
        if (Request::isPost()) {
            if (Request::submitted("save")) {
                CourseConfig::get(Context::get()->id)->store("KURSVORABINFO_TITLE", Request::get("splash_title"));
                CourseConfig::get(Context::get()->id)->store("KURSVORABINFO_INFO", Request::get("splash_info"));
                PageLayout::postSuccess(_("Info wurde gespeichert."));
            } elseif (Request::submitted("delete")) {
                CourseConfig::get(Context::get()->id)->store("KURSVORABINFO_TITLE", "");
                CourseConfig::get(Context::get()->id)->store("KURSVORABINFO_INFO", "");
                PageLayout::postSuccess(_("Info wurde gelöscht."));
            }
        }
    }
}