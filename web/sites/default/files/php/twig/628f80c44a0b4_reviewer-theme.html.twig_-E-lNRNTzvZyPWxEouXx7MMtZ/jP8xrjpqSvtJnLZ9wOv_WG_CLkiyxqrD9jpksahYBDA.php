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

/* modules/custom/reviewer/templates/reviewer-theme.html.twig */
class __TwigTemplate_77165bd261ff5459a9c97a071bf59d6b extends \Twig\Template
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
        // line 1
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["form"] ?? null), 1, $this->source), "html", null, true);
        echo "

";
        // line 3
        if ((($__internal_compile_0 = (($__internal_compile_1 = ($context["reviews"] ?? null)) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1["table"] ?? null) : null)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0["#rows"] ?? null) : null)) {
            // line 4
            echo "  <div style=\"height: auto;\">
    <table";
            // line 5
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => "table"], "method", false, false, true, 5), 5, $this->source), "html", null, true);
            echo ">
      ";
            // line 6
            if ((($__internal_compile_2 = (($__internal_compile_3 = ($context["reviews"] ?? null)) && is_array($__internal_compile_3) || $__internal_compile_3 instanceof ArrayAccess ? ($__internal_compile_3["table"] ?? null) : null)) && is_array($__internal_compile_2) || $__internal_compile_2 instanceof ArrayAccess ? ($__internal_compile_2["#header"] ?? null) : null)) {
                // line 7
                echo "        <thead>
          <tr>
            ";
                // line 9
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable((($__internal_compile_4 = (($__internal_compile_5 = ($context["reviews"] ?? null)) && is_array($__internal_compile_5) || $__internal_compile_5 instanceof ArrayAccess ? ($__internal_compile_5["table"] ?? null) : null)) && is_array($__internal_compile_4) || $__internal_compile_4 instanceof ArrayAccess ? ($__internal_compile_4["#header"] ?? null) : null));
                foreach ($context['_seq'] as $context["_key"] => $context["cell"]) {
                    // line 10
                    echo "              <td>";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["cell"], 10, $this->source), "html", null, true);
                    echo "</td>
            ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['cell'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 12
                echo "          </tr>
        </thead>
      ";
            }
            // line 15
            echo "      <tbody>
        ";
            // line 16
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((($__internal_compile_6 = (($__internal_compile_7 = ($context["reviews"] ?? null)) && is_array($__internal_compile_7) || $__internal_compile_7 instanceof ArrayAccess ? ($__internal_compile_7["table"] ?? null) : null)) && is_array($__internal_compile_6) || $__internal_compile_6 instanceof ArrayAccess ? ($__internal_compile_6["#rows"] ?? null) : null));
            $context['loop'] = [
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            ];
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
                // line 17
                echo "          ";
                $context["row_classes"] = [0 => (( !                // line 18
($context["no_striping"] ?? null)) ? (twig_cycle([0 => "odd", 1 => "even"], $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, true, 18), 18, $this->source))) : (""))];
                // line 20
                echo "          <tr";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["row"], "attributes", [], "any", false, false, true, 20), "addClass", [0 => ($context["row_classes"] ?? null)], "method", false, false, true, 20), 20, $this->source), "html", null, true);
                echo ">
            <td class=\"personal-info\">
              <div class=\"fix-size\">
                ";
                // line 23
                if ((($__internal_compile_8 = $context["row"]) && is_array($__internal_compile_8) || $__internal_compile_8 instanceof ArrayAccess ? ($__internal_compile_8["user_image"] ?? null) : null)) {
                    // line 24
                    echo "                  <a href=\"";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_9 = $context["row"]) && is_array($__internal_compile_9) || $__internal_compile_9 instanceof ArrayAccess ? ($__internal_compile_9["user_image"] ?? null) : null), 24, $this->source), "html", null, true);
                    echo "\" target=\"_blank\">
                    <img
                      class=\"user-image\"
                      src=\"";
                    // line 27
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_10 = $context["row"]) && is_array($__internal_compile_10) || $__internal_compile_10 instanceof ArrayAccess ? ($__internal_compile_10["user_image"] ?? null) : null), 27, $this->source), "html", null, true);
                    echo "\"
                      alt=\"";
                    // line 28
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_11 = $context["row"]) && is_array($__internal_compile_11) || $__internal_compile_11 instanceof ArrayAccess ? ($__internal_compile_11["name"] ?? null) : null), 28, $this->source), "html", null, true);
                    echo "\"
                      width = \"150px\"
                      height = \"150px\"
                      style = \"border-radius: 50px\"
                      title=\"";
                    // line 32
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_12 = $context["row"]) && is_array($__internal_compile_12) || $__internal_compile_12 instanceof ArrayAccess ? ($__internal_compile_12["name"] ?? null) : null), 32, $this->source), "html", null, true);
                    echo "\"/>
                  </a>
                ";
                } else {
                    // line 35
                    echo "                  <img
                    class=\"default-user-image user-image\"
                    src=\"/modules/custom/reviewer/images/user_image/default.jpg\"
                    alt=\"";
                    // line 38
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_13 = $context["row"]) && is_array($__internal_compile_13) || $__internal_compile_13 instanceof ArrayAccess ? ($__internal_compile_13["name"] ?? null) : null), 38, $this->source), "html", null, true);
                    echo "\"
                    width = \"150px\"
                    height = \"150px\"
                    style = \"border-radius: 50px\"
                    title=\"";
                    // line 42
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_14 = $context["row"]) && is_array($__internal_compile_14) || $__internal_compile_14 instanceof ArrayAccess ? ($__internal_compile_14["name"] ?? null) : null), 42, $this->source), "html", null, true);
                    echo "\"/> 
                ";
                }
                // line 44
                echo "              </div>
              <div class=\"user-name\">";
                // line 45
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_15 = $context["row"]) && is_array($__internal_compile_15) || $__internal_compile_15 instanceof ArrayAccess ? ($__internal_compile_15["name"] ?? null) : null), 45, $this->source), "html", null, true);
                echo "</div>
              <div class=\"submit-date\">";
                // line 46
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, twig_date_format_filter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_16 = $context["row"]) && is_array($__internal_compile_16) || $__internal_compile_16 instanceof ArrayAccess ? ($__internal_compile_16["timestamp"] ?? null) : null), 46, $this->source), "m/j/Y H:i:s"), "html", null, true);
                echo "</div>
            </td>
            <td class=\"feedback-message\">
              <div class=\"user-message\">";
                // line 49
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_17 = $context["row"]) && is_array($__internal_compile_17) || $__internal_compile_17 instanceof ArrayAccess ? ($__internal_compile_17["message"] ?? null) : null), 49, $this->source), "html", null, true);
                echo "</div>
              <div class=\"fix-size\">
                ";
                // line 51
                if ((($__internal_compile_18 = $context["row"]) && is_array($__internal_compile_18) || $__internal_compile_18 instanceof ArrayAccess ? ($__internal_compile_18["image"] ?? null) : null)) {
                    // line 52
                    echo "                  <a href=\"";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_19 = $context["row"]) && is_array($__internal_compile_19) || $__internal_compile_19 instanceof ArrayAccess ? ($__internal_compile_19["image"] ?? null) : null), 52, $this->source), "html", null, true);
                    echo "\" target=\"_blank\">
                    <img
                      class=\"image\"
                      src=\"";
                    // line 55
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_20 = $context["row"]) && is_array($__internal_compile_20) || $__internal_compile_20 instanceof ArrayAccess ? ($__internal_compile_20["image"] ?? null) : null), 55, $this->source), "html", null, true);
                    echo "\"
                      alt=\"";
                    // line 56
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_21 = $context["row"]) && is_array($__internal_compile_21) || $__internal_compile_21 instanceof ArrayAccess ? ($__internal_compile_21["name"] ?? null) : null), 56, $this->source), "html", null, true);
                    echo "\"
                      width = \"200px\"
                      height = \"125px\"
                      style = \"border-radius: 10px\"
                      title=\"";
                    // line 60
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_22 = $context["row"]) && is_array($__internal_compile_22) || $__internal_compile_22 instanceof ArrayAccess ? ($__internal_compile_22["name"] ?? null) : null), 60, $this->source), "html", null, true);
                    echo "\"/>
                  </a>
                ";
                }
                // line 63
                echo "              </div>
            </td>
            <td class=\"contact-info\">
              <div class=\"user-email\">";
                // line 66
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_23 = $context["row"]) && is_array($__internal_compile_23) || $__internal_compile_23 instanceof ArrayAccess ? ($__internal_compile_23["email"] ?? null) : null), 66, $this->source), "html", null, true);
                echo "</div>
              <div class=\"user-phone\">";
                // line 67
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_24 = $context["row"]) && is_array($__internal_compile_24) || $__internal_compile_24 instanceof ArrayAccess ? ($__internal_compile_24["phone"] ?? null) : null), 67, $this->source), "html", null, true);
                echo "</div>
            </td>
             ";
                // line 69
                if (twig_in_filter("administrator", twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "getroles", [], "any", false, false, true, 69))) {
                    // line 70
                    echo "              <td class=\"option-links\">
                <div>
                  <button
                    type=\"button\"
                    class=\"btn btn-outline-danger btn-lg use-ajax delete\"
                    href=\"";
                    // line 75
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->getPath("reviewerdelete.content", ["id" => (($__internal_compile_25 = $context["row"]) && is_array($__internal_compile_25) || $__internal_compile_25 instanceof ArrayAccess ? ($__internal_compile_25["id"] ?? null) : null)]), "html", null, true);
                    echo "\"
                    data-dialog-options=\"{&quot;width&quot;:400}\"
                    data-dialog-type=\"modal\">
                    Delete
                  </button>
                </div>
                <div>
                   <button
                    type=\"button\"
                    class=\"btn btn-outline-success btn-lg use-ajax edit\"
                    href=\"";
                    // line 85
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->getPath("revieweredit.content", ["id" => (($__internal_compile_26 = $context["row"]) && is_array($__internal_compile_26) || $__internal_compile_26 instanceof ArrayAccess ? ($__internal_compile_26["id"] ?? null) : null)]), "html", null, true);
                    echo "\"
                    data-dialog-options=\"{&quot;width&quot;:400}\"
                    data-dialog-type=\"modal\">
                    Edit
                  </button>
                </div>
              </td>
            ";
                }
                // line 93
                echo "          </tr>
        ";
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['length'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 95
            echo "        </tbody>
    </table>
  </div>
";
        }
    }

    public function getTemplateName()
    {
        return "modules/custom/reviewer/templates/reviewer-theme.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  257 => 95,  242 => 93,  231 => 85,  218 => 75,  211 => 70,  209 => 69,  204 => 67,  200 => 66,  195 => 63,  189 => 60,  182 => 56,  178 => 55,  171 => 52,  169 => 51,  164 => 49,  158 => 46,  154 => 45,  151 => 44,  146 => 42,  139 => 38,  134 => 35,  128 => 32,  121 => 28,  117 => 27,  110 => 24,  108 => 23,  101 => 20,  99 => 18,  97 => 17,  80 => 16,  77 => 15,  72 => 12,  63 => 10,  59 => 9,  55 => 7,  53 => 6,  49 => 5,  46 => 4,  44 => 3,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{{ form }}

{% if reviews['table']['#rows'] %}
  <div style=\"height: auto;\">
    <table{{ attributes.addClass('table') }}>
      {% if reviews['table']['#header'] %}
        <thead>
          <tr>
            {% for cell in reviews['table']['#header'] %}
              <td>{{ cell }}</td>
            {% endfor %}
          </tr>
        </thead>
      {% endif %}
      <tbody>
        {% for row in reviews['table']['#rows'] %}
          {% set row_classes = [
            not no_striping ? cycle(['odd', 'even'], loop.index0),
          ] %}
          <tr{{ row.attributes.addClass(row_classes) }}>
            <td class=\"personal-info\">
              <div class=\"fix-size\">
                {% if row['user_image'] %}
                  <a href=\"{{ row['user_image'] }}\" target=\"_blank\">
                    <img
                      class=\"user-image\"
                      src=\"{{ row['user_image'] }}\"
                      alt=\"{{ row['name'] }}\"
                      width = \"150px\"
                      height = \"150px\"
                      style = \"border-radius: 50px\"
                      title=\"{{ row['name'] }}\"/>
                  </a>
                {% else %}
                  <img
                    class=\"default-user-image user-image\"
                    src=\"/modules/custom/reviewer/images/user_image/default.jpg\"
                    alt=\"{{ row['name'] }}\"
                    width = \"150px\"
                    height = \"150px\"
                    style = \"border-radius: 50px\"
                    title=\"{{ row['name'] }}\"/> 
                {% endif %}
              </div>
              <div class=\"user-name\">{{ row['name'] }}</div>
              <div class=\"submit-date\">{{ row['timestamp']|date('m/j/Y H:i:s') }}</div>
            </td>
            <td class=\"feedback-message\">
              <div class=\"user-message\">{{ row['message'] }}</div>
              <div class=\"fix-size\">
                {% if row['image'] %}
                  <a href=\"{{ row['image'] }}\" target=\"_blank\">
                    <img
                      class=\"image\"
                      src=\"{{ row['image'] }}\"
                      alt=\"{{ row['name'] }}\"
                      width = \"200px\"
                      height = \"125px\"
                      style = \"border-radius: 10px\"
                      title=\"{{ row['name'] }}\"/>
                  </a>
                {% endif %}
              </div>
            </td>
            <td class=\"contact-info\">
              <div class=\"user-email\">{{ row['email'] }}</div>
              <div class=\"user-phone\">{{ row['phone'] }}</div>
            </td>
             {% if 'administrator' in user.getroles %}
              <td class=\"option-links\">
                <div>
                  <button
                    type=\"button\"
                    class=\"btn btn-outline-danger btn-lg use-ajax delete\"
                    href=\"{{ path('reviewerdelete.content', {'id': row['id']}) }}\"
                    data-dialog-options=\"{&quot;width&quot;:400}\"
                    data-dialog-type=\"modal\">
                    Delete
                  </button>
                </div>
                <div>
                   <button
                    type=\"button\"
                    class=\"btn btn-outline-success btn-lg use-ajax edit\"
                    href=\"{{ path('revieweredit.content', {'id': row['id']}) }}\"
                    data-dialog-options=\"{&quot;width&quot;:400}\"
                    data-dialog-type=\"modal\">
                    Edit
                  </button>
                </div>
              </td>
            {% endif %}
          </tr>
        {% endfor %}
        </tbody>
    </table>
  </div>
{% endif %}", "modules/custom/reviewer/templates/reviewer-theme.html.twig", "/var/www/web/modules/custom/reviewer/templates/reviewer-theme.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 3, "for" => 9, "set" => 17);
        static $filters = array("escape" => 1, "date" => 46);
        static $functions = array("cycle" => 18, "path" => 75);

        try {
            $this->sandbox->checkSecurity(
                ['if', 'for', 'set'],
                ['escape', 'date'],
                ['cycle', 'path']
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
