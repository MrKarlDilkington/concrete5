<?php

defined('C5_EXECUTE') or die("Access Denied.");

?>


<form method="post" action="<?=$view->action('submit', $element->getID())?>">
    <?=$token->output('submit')?>

    <div data-form="customize-slot" v-cloak>

        <input type="hidden" name="selectedTemplateJson" :value="selectedTemplateJson">

        <div v-for="(templateOption, index) in templateOptions">

            <div>
                <div class="form-group">
                    <div class="form-check">
                        <input type="radio" class="form-check-input" :value="index" name="selectedTemplateOption"
                               v-model="selectedTemplateOption">
                        <span class="text-muted"><?= t('Template Name:') ?> {{templateOption.template.name}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 pl-0">

                    <span v-html="templateOption.content"></span>
                    <hr>

                </div>
            </div>

        </div>

    </div>

    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <button type="submit" class="btn float-right btn-secondary"><?=t('Next')?></button>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(function() {
        Concrete.Vue.activateContext('cms', function (Vue, config) {
            new Vue({
                el: 'div[data-form=customize-slot]',
                components: config.components,
                computed: {
                    'selectedTemplateJson': function() {
                        return JSON.stringify(this.templateOptions[this.selectedTemplateOption])
                    }
                },
                data: {
                    templateOptions: <?=$templateOptions?>,
                    selectedTemplateOption: 0
                },

                watch: {},

                methods: {
                }
            })
        })
    });
</script>