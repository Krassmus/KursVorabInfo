<?php

class KursVorabInfo extends StudIPPlugin implements DetailspagePlugin, SystemPlugin
{
    public function __construct()
    {
        parent::__construct();
        if (Navigation::hasItem("/course") && Navigation::hasItem("/course/admin") && Context::get()->id && $GLOBALS['perm']->have_studip_perm("tutor", Context::get()->id)) {
            $nav = new Navigation(_("Eingangsinformationen"), PluginEngine::getURL($this, array(), "splash/edit"));
            $nav->setImage(Icon::create("infopage", "navigation"));
            $nav->setDescription(_("Geben Sie hier Informationen ein, die vor Anmeldung zur Veranstaltung angezeigt werden und mindestens einmal beim Betreten der Veranstaltung."));
            Navigation::addItem("/course/admin/splash", $nav);
        }
        if (Navigation::hasItem("/course")
                && Context::get()->id
                && !$GLOBALS['perm']->have_studip_perm("admin", Context::get()->id)
                && !UserConfig::get($GLOBALS['user']->id)->getValue("KURSVORABINFO_VISITED_".Context::get()->id)
                && CourseConfig::get(Context::get()->id)->KURSVORABINFO_INFO) {
            // setup splash screen:
            $this->addStylesheet("assets/splashscreen.less");
            PageLayout::addBodyElements('<div id="splash_screen"><div class="splash_box">'.formatReady(CourseConfig::get(Context::get()->id)->COURSE_SPLASH_SCREEN_INFO).'</div><div class="splash_box">'.\Studip\LinkButton::create(_("Gelesen und weiter zur Veranstaltung"), PluginEngine::getURL($this, array(), "referrer/".Context::get()->id)).'</div></div>');
        }
    }

    public function referrer_action($course_id)
    {
        UserConfig::get($GLOBALS['user']->id)->store("KURSVORABINFO_VISITED_".$course_id, 1);
        header("Location: ".URLHelper::getURL("seminar_main.php", array('sem_id' => $course_id)));
        die();
    }

    function getDetailspageTemplate($course)
    {
        if (!CourseConfig::get($course->id)->KURSVORABINFO_INFO) {
            return null;
        } else {
            $tf = new Flexi_TemplateFactory(__DIR__ . "/views");

            $template = $tf->open("widget/info");
            $template->title = CourseConfig::get($course->id)->KURSVORABINFO_TITLE ?: _("Erklärung");
            $template->course = $course;
            return $template;
        }
    }
}