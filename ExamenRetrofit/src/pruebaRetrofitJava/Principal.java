package pruebaRetrofitJava;

import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;





/***************************************
 * SE PUEDEN DESCARGAR JARS DE CONVERTIDORES DE AQUÍ:
 * http://search.maven.org/
 * 
 * Por ejemplo:
 * http://search.maven.org/#search%7Cga%7C1%7Cg%3A%22com.squareup.retrofit2%22
 * 
 * Si usamos gradle, simplemente añadiríamos la dependencia:
 * com.squareup.retrofit2:converter-gson/home/migue/Descargas/converter-gson-2.1.0.jar
 *
 */



public class Principal {
	
	private final static String SERVER_URL = "https://putsreq.com/";

	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
		Retrofit retrofit;
		ListPedidosCallback listPedidosCallback = new ListPedidosCallback();
		
		retrofit = new Retrofit.Builder()
							   .baseUrl(SERVER_URL)
							   .addConverterFactory(GsonConverterFactory.create())
							   .build();
		
		PedidoInterface pedidoInter = retrofit.create(PedidoInterface.class);

		pedidoInter.getListPedidos().enqueue(listPedidosCallback);
	}
}
