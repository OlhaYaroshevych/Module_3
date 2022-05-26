<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* themes/contrib/bootstrap_barrio/templates/form/dropbutton-wrapper.html.twig */
class __TwigTemplate_fe9dbfd01d1e8c44c30f917fa13999a1 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 13
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("bootstrap_barrio/dropbutton"), "html", null, true);
        echo "

";
        // line 15
        if (($context["children"] ?? null)) {
            // line 16
            echo "  ";
            ob_start();
            // line 17
            echo "    <div class=\"dropbutton-wrapper\">
      <div class=\"dropbutton-widget\">
        ";
            // line 19
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["children"] ?? null), 19, $this->source), "html", null, true);
            echo "
      </div>
    </div>
  ";
            echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        }
    }

    public function getTemplateName()
    {
        return "themes/contrib/bootstrap_barrio/templates/form/dropbutton-wrapper.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  53 => 19,  49 => 17,  46 => 16,  44 => 15,  39 => 13,);
    }

    public function getSourceContext()
    {
        return new Source("{#
/**
 * @file
 * Theme override for a dropbutton wrapper.
 *
 * Available variables:
 * - children: Contains the child elements of the dropbutton menu.
 *
 * @see template_preprocess()
 * @see template_preprocess_dropbutton_wrapper()
 */
#}
{{ attach_library('bootstrap_barrio/dropbutton') }}

{% if children %}
  {% spaceless %}
    <div class=\"dropbutton-wrapper\">
      <div class=\"dropbutton-widget\">
        {{ children }}
      </div>
    </div>
  {% endspaceless %}
{% endif %}
", "themes/contrib/bootstrap_barrio/templates/form/dropbutton-wrapper.html.twig", "/var/www/web/themes/contrib/bootstrap_barrio/templates/form/dropbutton-wrapper.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 15, "spaceless" => 16);
        static $filters = array("escape" => 13);
        static $functions = array("attach_library" => 13);

        try {
            $this->sandbox->checkSecurity(
                ['if', 'spaceless'],
                ['escape'],
                ['attach_library']
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
