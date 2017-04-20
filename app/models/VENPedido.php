<?php
class VENPedido extends Eloquent
{
	protected $table='VEN.Pedido';
	protected $primaryKey='Id';
	public $timestamps=false;
	public function VENDetallePedido()
	{
		return $this->belongsTo('VENDetallePedido', 'Id');
	}
}
?>