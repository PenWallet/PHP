package pruebaRetrofitJava;

import okhttp3.Headers;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import java.util.ArrayList;
import java.util.List;


public class ListPedidosCallback implements Callback<List<Pedido>>
{

	@Override
	public void onFailure(Call<List<Pedido>> arg0, Throwable arg1) {
		System.out.println("(   )\n" +
				"  (   ) (\n" +
				"   ) _   )\n" +
				"    ( \\_\n" +
				"  _(_\\ \\)__\n" +
				" (____\\___))");
	}

	@Override
	public void onResponse(Call<List<Pedido>> arg0, Response<List<Pedido>> resp)
	{
		// TODO Auto-generated method stub
		String contentType;
		int code;
		String message;
		boolean isSuccesful;
		ArrayList<Pedido> lista = new ArrayList<>(resp.body());

		Headers cabeceras = resp.headers();
		contentType = cabeceras.get("Content-Type");
		code = resp.code();
		message = resp.message();
		isSuccesful = resp.isSuccessful();
		ArrayList<Producto> listaProductos;

		for(Pedido pedido : lista)
		{
			System.out.println("\nPedido con ID "+pedido.getId()+",estos son sus productos:");
			listaProductos = new ArrayList<>(pedido.getListaProductos());
			for(Producto producto : listaProductos)
			{
				//Se pué hacer más bonico, pero ¯\_(ツ)_/¯
				System.out.println(producto.toString());
			}
		}

	}
	

}
