<?php
class VENDetallePedido extends Eloquent
{
	protected $table='VEN.DetallePedido';
	protected $primaryKey='Id';
	public $timestamps=false;
	public function VENPedido()
	{
		return $this->hasMany('VENPedido', 'Id');
	}
}
?>