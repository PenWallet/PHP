package pruebaRetrofitJava;
import retrofit2.Call;
import retrofit2.http.GET;
import retrofit2.http.Path;



public interface LibroInterface {

	@GET("/libro/{id}")
	Call<Libro> getLibro (@Path("id") int id);

}
