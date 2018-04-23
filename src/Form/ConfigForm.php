<?php

/**
* @file
* Contains \Drupal\my_module\Form\MyModuleForm.
*/

namespace Drupal\mydata\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class ConfigForm extends ConfigFormBase {
  /**
  * {@inheritdoc}
  */
  public function getFormId() {
    return 'module_form';
  }

  /**
  * {@inheritdoc}
  */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('module.settings');

      $form['opcion'] = array(
          '#type' => 'radios',
          '#title' => $this->t('Seleccione la opción de visualización de imágenes'),
          '#options'=>array(t('Slider'),t('Listado')),
          '#default_value' => $config->get('opcion'),
          '#required'=>true,

      );

    return parent::buildForm($form, $form_state);
  }

  /**
  * {@inheritdoc}
  */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
      $config = $this->config('module.settings');
      $config->set('opcion', $form_state->getValue('opcion'))
          ->save();

  }

    /**
     * {@inheritdoc}
     */
    public  function validateForm(array &$form, FormStateInterface $form_state) {
        parent::validateForm($form,$form_state);
//        if(empty($form_state->getValue('api_key_text')) ){
//            $form_state->setError($form['api_key_text'],'You must define the API key.');
//        }
    }

    protected function getEditableConfigNames() {
        return [
            'module.settings',
        ];
    }
}
