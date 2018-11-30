package pruebaRetrofitJava;
import java.util.Arrays;
import java.util.List;

public class Pedido {
	private int id;
	private List<Producto> productos;
	public Pedido(int codigo, List<Producto> listaProductos) {
		this.id = codigo;
		this.productos = listaProductos;
	}

	public int getId() {
		return id;
	}
	public void setId(int id) {
		this.id = id;
	}

	public List<Producto> getListaProductos() {
		return productos;
	}

	public void setListaProductos(List<Producto> listaProductos) {
		this.productos = listaProductos;
	}
}
