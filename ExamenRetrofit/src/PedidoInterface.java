package pruebaRetrofitJava;
import retrofit2.Call;
import retrofit2.http.*;

import java.util.List;


public interface PedidoInterface {

	@GET("/KDtOzbc1yLWAI0DqqyPw")
	Call<List<Pedido>> getListPedidos();
}
