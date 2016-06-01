package com.sin.movies.pages;

import java.util.ArrayList;
import java.util.List;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import com.sin.movies.Const;
import com.sin.movies.R;
import com.sin.movies.network.ServerManager;

import android.content.Context;
import android.os.Bundle;
import android.util.TypedValue;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.TextView;
import common.design.layout.LayoutUtils;
import common.design.layout.ScreenAdapter;
import common.library.utils.AlgorithmUtils;
import common.library.utils.MessageUtils;
import common.list.adapter.ItemCallBack;
import common.list.adapter.ItemResult;
import common.list.adapter.MyListAdapter;
import common.list.adapter.ViewHolder;
import common.manager.activity.ActivityManager;
import common.network.utils.LogicResult;
import common.network.utils.ResultCallBack;

public class CategoryActivity extends HeaderBarActivity {
	GridView				m_categorylist	= null;
	GridView				m_countrylist	= null;
	GridView				m_movielist	= null;
	ImageView 				m_arrayleft = null;
	ImageView				m_arrayright = null;
	ItemCategoryGridAdapter 		m_categoryadapterGrid = null;
	ItemCountryGridAdapter 			m_countryadapterGrid = null;
	ItemMovieGridAdapter 			m_movieadapterGrid = null;
	int						pageno = 1;
	int						limit = 12;
	int						catid = 0;
	int						cid = 0;
	List<JSONObject> 		categorylist = null;
	List<JSONObject> 		countrylist = null;
	List<JSONObject> 		movielist = null;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.layout_category);
		
		loadComponents();
	}
	
	protected void findViews()
	{
		super.findViews();

		m_categorylist = (GridView) findViewById(R.id.category_list);
		m_countrylist = (GridView) findViewById(R.id.country_list);
		m_movielist = (GridView) findViewById(R.id.movie_list);
		m_arrayleft = (ImageView) findViewById(R.id.array_left);
		m_arrayright = (ImageView) findViewById(R.id.array_right);
	}
	
	protected void initData()
	{
		super.initData();	
		
		GetMovieList();
		GetCategoryList();
		GetCountryList();
	}
	private void GetMovieList(){
		 showLoadingProgress();
		 ServerManager.getMovie(catid, cid, pageno, limit, new ResultCallBack() {
				
			@Override
			public void doAction(LogicResult result) {
				hideProgress();
				JSONObject data = result.getData();
				if( data == null || data.has("content") == false )
				{
					return;
				}		
				
				JSONArray array = data.optJSONArray("content");
				movielist = AlgorithmUtils.jsonarrayToList(array);
				m_movieadapterGrid = new ItemMovieGridAdapter(CategoryActivity.this, movielist, R.layout.fragment_movie_item, null);		
				m_movielist.setAdapter(m_movieadapterGrid);      	
				m_movielist.requestFocus();
				m_movielist.setSelection(0);
				m_movielist.setItemChecked(0, true);
				
			}
		});
	}
	private void GetCategoryList(){
		 showLoadingProgress();
		 ServerManager.getCategory( new ResultCallBack() {
				
			@Override
			public void doAction(LogicResult result) {
				hideProgress();
				JSONObject data = result.getData();
				if( data == null || data.has("content") == false )
				{
					return;
				}		
				
				JSONArray array = data.optJSONArray("content");
				categorylist = AlgorithmUtils.jsonarrayToList(array);
				m_categoryadapterGrid = new ItemCategoryGridAdapter(CategoryActivity.this, categorylist, R.layout.fragment_category_item, null);		
				m_categorylist.setAdapter(m_categoryadapterGrid);    	
				m_categorylist.requestFocus();
				m_categorylist.setSelection(0);
				m_categorylist.setItemChecked(0, true);
				
			}
		});
	}
	private void GetCountryList(){
		 showLoadingProgress();
		 ServerManager.getCountry( new ResultCallBack() {
				
			@Override
			public void doAction(LogicResult result) {
				hideProgress();
				JSONObject data = result.getData();
				if( data == null || data.has("content") == false )
				{
					return;
				}		
				
				JSONArray array = data.optJSONArray("content");
				countrylist = AlgorithmUtils.jsonarrayToList(array);
				m_countryadapterGrid = new ItemCountryGridAdapter(CategoryActivity.this, countrylist, R.layout.fragment_category_item, null);		
				m_countrylist.setAdapter(m_countryadapterGrid);    	
				m_countrylist.requestFocus();
				m_countrylist.setSelection(0);
				m_countrylist.setItemChecked(0, true);
				
			}
		});
	}
	protected void layoutControls()
	{
		super.layoutControls();
		
		LayoutUtils.setMargin(m_movielist, ScreenAdapter.getDeviceWidth() / 8, 0, ScreenAdapter.getDeviceWidth() / 8, 0, true);
		LayoutUtils.setMargin(m_countrylist, ScreenAdapter.getDeviceWidth() / 7, 0, ScreenAdapter.getDeviceWidth() / 7, 0, true);
		LayoutUtils.setMargin(m_categorylist, ScreenAdapter.getDeviceWidth() / 7, 0, ScreenAdapter.getDeviceWidth() / 7, 0, true);
		LayoutUtils.setMargin(m_arrayleft, ScreenAdapter.getDeviceWidth() / 8, 0, ScreenAdapter.getDeviceWidth() / 8, 0, true);
		LayoutUtils.setSize(m_arrayleft, 50, 100, true);
		LayoutUtils.setMargin(m_arrayright, ScreenAdapter.getDeviceWidth() / 8, 0, ScreenAdapter.getDeviceWidth() / 8, 0, true);
		LayoutUtils.setSize(m_arrayright, 50, 100, true);
	}
	
	protected void initEvents()
	{ 
		super.initEvents();

		m_movielist.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
				gotoOtherPage(position);
			}
		});		
		m_countrylist.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
				gotoOtherPage(position);
			}
		});		
		m_categorylist.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
				gotoOtherPage(position);
			}
		});	
	}
	
	private void gotoOtherPage(int position)
	{
		if( position == 0 )
			gotoPlayListPage();
		
		if( position == 3 )
			gotoProfilePage();
				
	}
	
	private void gotoPlayListPage()
	{
		Bundle bundle = new Bundle();
		bundle.putString(INTENT_EXTRA, "0");
		ActivityManager.changeActivity(this, PlayListActivity.class, bundle, false, null );
	}
	
	private void gotoProfilePage()
	{
		Bundle bundle = new Bundle();
		ActivityManager.changeActivity(this, ProfileActivity.class, bundle, false, null );
	}
	
	class ItemCategoryGridAdapter extends MyListAdapter{

    	public ItemCategoryGridAdapter(Context context, List<JSONObject> data, 
    			int resource, ItemCallBack callback) {
    		super(context, data, resource, callback);
    	}
    	
    	@Override
    	protected void loadItemViews(View rowView, final int position)
    	{
    		final JSONObject item = getItem(position);
    		
    		
    		LayoutUtils.setMargin(ViewHolder.get(rowView, R.id.txt_name), 0, 20, 0, 60, true);
    		((TextView)ViewHolder.get(rowView, R.id.txt_name)).setTextSize(TypedValue.COMPLEX_UNIT_PX, ScreenAdapter.computeHeight(60));
    		
    		((TextView)ViewHolder.get(rowView, R.id.txt_name)).setText(item.optString("name", ""));    		
    	}
    }
	class ItemCountryGridAdapter extends MyListAdapter{

    	public ItemCountryGridAdapter(Context context, List<JSONObject> data, 
    			int resource, ItemCallBack callback) {
    		super(context, data, resource, callback);
    	}
    	
    	@Override
    	protected void loadItemViews(View rowView, final int position)
    	{
    		final JSONObject item = getItem(position);
    		
    		
    		LayoutUtils.setMargin(ViewHolder.get(rowView, R.id.txt_name), 0, 20, 0, 60, true);
    		((TextView)ViewHolder.get(rowView, R.id.txt_name)).setTextSize(TypedValue.COMPLEX_UNIT_PX, ScreenAdapter.computeHeight(60));
    		
    		((TextView)ViewHolder.get(rowView, R.id.txt_name)).setText(item.optString("name", ""));    		
    	}
    }
	class ItemMovieGridAdapter extends MyListAdapter{

    	public ItemMovieGridAdapter(Context context, List<JSONObject> data, 
    			int resource, ItemCallBack callback) {
    		super(context, data, resource, callback);
    	}
    	
    	@Override
    	protected void loadItemViews(View rowView, final int position)
    	{
    		final JSONObject item = getItem(position);
    		
    		LayoutUtils.setSize(ViewHolder.get(rowView, R.id.img_thumbnail), 140, 140, true);    		
    		LayoutUtils.setMargin(ViewHolder.get(rowView, R.id.img_thumbnail), 0, 60, 0, 0, true);    		
    		
    		((ImageView)ViewHolder.get(rowView, R.id.img_thumbnail)).setImageResource(item.optInt("thumb", R.drawable.ic_launcher));
    	}
    }
	 
	 
}

