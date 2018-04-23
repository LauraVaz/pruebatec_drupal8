<?php

namespace Drupal\mydata\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\node\Entity\Node;
use Drupal\image\Entity\ImageStyle;


/**
 * Provides a 'MydataBlock' block.
 *
 * @Block(
 *  id = "mydata_block",
 *  admin_label = @Translation("Mydata block"),
 * )
 */
class MydataBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

      $contenido = "<ul>";


      $query = \Drupal::entityQuery('node')
          ->condition('type', 'publicidad')
          ->condition('status', 1)
          ->sort('created', 'DESC')
          ->range(0,3);

      $nids = $query->execute();

      foreach ($nids as $id) {
          $n = Node::load($id);
          $url[] = $n->get('field_image')->entity->url();
          $titulo[]=$n->get('field_titulo')->value;
             }
      $config = \Drupal::config('module.settings');
      $opcion='listado';
      if($config->get('opcion')==0)
          $opcion='slider';
      else
          $opcion='listado';
      $value=array_map(function ($r) {
          $n = Node::load($r);
          return [
              'url' => $n->get('field_image')->entity->url(),
              'titulo' => $n->get('field_titulo')->value,
              'descripcion'=>$n->get('field_descripcion')->value,
              'link'=>$n->get('field_link')->first()->getUrl(),
          ];
      }, $nids);
      $config = \Drupal::config('module.settings');
      if($config->get('opcion')==0 )
       $opcion='slider';
      else
          $opcion='listado';

      return ['#theme'=>$opcion,'#value'=>$value];
  }

}
