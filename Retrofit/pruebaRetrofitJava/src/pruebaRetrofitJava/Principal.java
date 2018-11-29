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
	
	private final static String SERVER_URL = "http://biblioteca.devel:8080";

	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
		Retrofit retrofit;
		LibroCallback libroCallback = new LibroCallback();
		LibroListCallback libroListCallback = new LibroListCallback();
		LibroVoidCallback libroVoidCallback = new LibroVoidCallback();
		
		retrofit = new Retrofit.Builder()
							   .baseUrl(SERVER_URL)
							   .addConverterFactory(GsonConverterFactory.create())
							   .build();
		
		LibroInterface libroInter = retrofit.create(LibroInterface.class);
		
		libroInter.getLibro(1).enqueue(libroCallback);

		libroInter.getListLibro().enqueue(libroListCallback);

		libroInter.deleteLibro(6).enqueue(libroVoidCallback);

		libroInter.postLibro(new Libro(0,"Libro novo", "900")).enqueue(libroVoidCallback);

		libroInter.putLibro(new Libro(1, "El cambiazo de Don Quixot", "3")).enqueue(libroVoidCallback);
	}
}
