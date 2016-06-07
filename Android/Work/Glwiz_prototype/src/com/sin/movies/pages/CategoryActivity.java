package com.sin.movies.pages;

import java.util.List;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import com.meetme.android.horizontallistview.HorizontalListView;
import com.nostra13.universalimageloader.core.DisplayImageOptions;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.sin.movies.Const;
import com.sin.movies.R;
import com.sin.movies.network.ServerManager;
import com.sin.movies.network.ServerTask;

import android.annotation.SuppressLint;
import android.content.Context;
import android.graphics.Color;
import android.os.Bundle;
import android.util.Log;
import android.util.TypedValue;
import android.view.KeyEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup.LayoutParams;
import android.view.inputmethod.EditorInfo;
import android.view.inputmethod.InputMethodManager;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.GridView;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.TextView.OnEditorActionListener;
import common.design.layout.LayoutUtils;
import common.design.layout.ScreenAdapter;
import common.image.load.ImageUtils;
import common.library.utils.AlgorithmUtils;
import common.list.adapter.ItemCallBack;
import common.list.adapter.MyListAdapter;
import common.list.adapter.ViewHolder;
import common.manager.activity.ActivityManager;
import common.network.utils.LogicResult;
import common.network.utils.ResultCallBack;

public class CategoryActivity extends HeaderBarActivity {
	HorizontalListView				m_categorylist	= null;
	HorizontalListView				m_countrylist	= null;
	GridView				m_movielist	= null;
	ImageButton 			m_arrayleft = null;
	ImageButton				m_arrayright = null;
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
	JSONArray				moviedata = null;
	JSONArray				categorydata = null;
	JSONArray				countrydata = null;
	LinearLayout			m_bottomlistview = null;
	Button 					m_searchbt = null;
	EditText				m_searchtext = null;
	String 					searchtext = "0";
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.layout_category);
		
		loadComponents();
	}
	
	protected void findViews()
	{
		super.findViews();

		m_categorylist = (HorizontalListView) findViewById(R.id.category_list);
		m_countrylist = (HorizontalListView) findViewById(R.id.country_list);
		m_movielist = (GridView) findViewById(R.id.movie_list);
		m_arrayleft = (ImageButton) findViewById(R.id.array_left);
		m_arrayright = (ImageButton) findViewById(R.id.array_right);
		m_bottomlistview = (LinearLayout) findViewById(R.id.bottomlist);
		m_searchbt = (Button) findViewById(R.id.searchbt);
		m_searchtext = (EditText) findViewById(R.id.searchtext);
		m_searchtext.setLines(1);
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
		 ServerManager.getMovie(catid, cid, pageno, limit, searchtext, new ResultCallBack() {
				
			@Override
			public void doAction(LogicResult result) {
				hideProgress();
				JSONObject data = result.getData();
				if( data == null || data.has("content") == false )
				{
					return;
				}		
				searchtext = "0";
				moviedata = data.optJSONArray("content");
				movielist = AlgorithmUtils.jsonarrayToList(moviedata);
				m_movieadapterGrid = new ItemMovieGridAdapter(CategoryActivity.this, movielist, R.layout.fragment_movie_item, null);		
				m_movielist.setAdapter(m_movieadapterGrid);      	
				m_movielist.requestFocus();
				m_movieadapterGrid.notifyDataSetChanged();
				
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
				JSONObject object1 = new JSONObject();
				try{
					object1.put("id", 0);
					object1.put("name", "All");
				}catch(Exception e){}
				categorydata = new JSONArray();
				categorydata.put(object1);
				JSONArray jsonarray = data.optJSONArray("content");
				for (int i = 0; i < jsonarray.length(); i++) {
					try {
						categorydata.put(jsonarray.get(i));
					} catch (JSONException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					}
			    }
				categorylist = AlgorithmUtils.jsonarrayToList(categorydata);
				m_categoryadapterGrid = new ItemCategoryGridAdapter(CategoryActivity.this, categorylist, R.layout.fragment_category_item, null);		
				m_categorylist.setAdapter(m_categoryadapterGrid);
				m_categorylist.setSelection(0);
				m_categoryadapterGrid.notifyDataSetChanged();
				
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
				JSONObject object1 = new JSONObject();
				try{
					object1.put("id", 0);
					object1.put("name", "All");
				}catch(Exception e){}
				countrydata = new JSONArray();
				countrydata.put(object1);
				JSONArray jsonarray = data.optJSONArray("content");
				for (int i = 0; i < jsonarray.length(); i++) {
					try {
						countrydata.put(jsonarray.get(i));
					} catch (JSONException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					}
			    }
				countrylist = AlgorithmUtils.jsonarrayToList(countrydata);
				m_countryadapterGrid = new ItemCountryGridAdapter(CategoryActivity.this, countrylist, R.layout.fragment_category_item, null);		
				m_countrylist.setAdapter(m_countryadapterGrid);  
				m_countrylist.setSelection(0);
				m_countryadapterGrid.notifyDataSetChanged();
				
			}
		});
	}
	protected void layoutControls()
	{
		super.layoutControls();
		int width = ScreenAdapter.getDeviceWidth();
		int height = ScreenAdapter.getDeviceHeight();
		if(width < height){
			int h = height;
			height = width;
			width = h;
		}
		
		LayoutUtils.setMargin(findViewById(R.id.lay_top_bar), 0, 10, 0, 0, true);
		m_searchbt.setTextSize(TypedValue.COMPLEX_UNIT_PX, ScreenAdapter.computeHeight(40));
		LayoutUtils.setSize(m_searchbt, 200, 70, true);
		
		LayoutUtils.setMargin(m_movielist, 0, 30, 0, 0, true);
		LayoutUtils.setSize(m_movielist, 0, ScreenAdapter.computeHeight(700), true);

		LayoutUtils.setSize(m_arrayleft, 40, 80, true);
		LayoutUtils.setSize(m_arrayright, 40, 80, true);
		LayoutUtils.setMargin(m_arrayleft, 40, 0, 40, 0, true);
		LayoutUtils.setMargin(m_arrayright, 40, 0, 40, 0, true);
		
		LayoutUtils.setMargin(m_bottomlistview, 0,  20, 0, 10, true);
		
		LayoutUtils.setSize(m_countrylist, LayoutParams.MATCH_PARENT, 90, true);
		LayoutUtils.setSize(m_categorylist, LayoutParams.MATCH_PARENT, 90, true);
		LayoutUtils.setPadding(m_countrylist, 0, 0, 0, 5, true);
		LayoutUtils.setPadding(m_categorylist, 0, 0, 0, 15, true);
		
		
	}
	
	protected void initEvents()
	{ 
		super.initEvents();

		m_movielist.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
				gotoPlayPage(position);
			}
		});		
		m_arrayleft.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				if(pageno > 1){
					pageno = pageno - 1;
					GetMovieList();
				}
			}
			
		});	
		m_arrayright.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				pageno = pageno + 1;
				GetMovieList();
			}
			
		});	
		m_countrylist.setOnItemClickListener(new OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view, int position, long id) {

				//m_countryadapterGrid.notifyDataSetChanged();
				((TextView)view.findViewById(R.id.txt_name)).setTextColor(Color.GRAY);
				((ImageView)view.findViewById(R.id.imageView1)).setVisibility(View.VISIBLE);
				JSONObject object = countrylist.get(position);
				try{
					cid = object.getInt("id");
					GetMovieList();
				}catch(Exception e){}
				//gotoPlayPage(position);
			}
		});		
		m_categorylist.setOnItemClickListener(new OnItemClickListener() {

			@SuppressLint("ResourceAsColor")
			@Override
			public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
				//m_categoryadapterGrid.notifyDataSetChanged();
				((TextView)view.findViewById(R.id.txt_name)).setTextColor(Color.GRAY);
				((ImageView)view.findViewById(R.id.imageView1)).setVisibility(View.VISIBLE);
				JSONObject object = countrylist.get(position);
				try{
					catid = object.getInt("id");
					GetMovieList();
				}catch(Exception e){}
				
				//gotoOtherPage(position);
			}
		});	
		m_searchbt.setOnClickListener(new View.OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				searchtext = m_searchtext.getText().toString();
				if(!searchtext.equals("")){
					GetMovieList();
				}
				InputMethodManager imm = (InputMethodManager) 
				        getSystemService(Context.INPUT_METHOD_SERVICE);
				    imm.hideSoftInputFromWindow(m_searchtext.getWindowToken(), 0);
			}
		});
		m_searchtext.setOnKeyListener(new View.OnKeyListener() {
			
			@Override
			public boolean onKey(View v, int keyCode, KeyEvent event) {
				// TODO Auto-generated method stub
				if ((event.getAction() == KeyEvent.ACTION_DOWN) && (keyCode == KeyEvent.KEYCODE_ENTER))
				{
					searchtext = m_searchtext.getText().toString();
					if(!searchtext.equals("")){
						GetMovieList();
					}
					InputMethodManager imm = (InputMethodManager) 
					        getSystemService(Context.INPUT_METHOD_SERVICE);
					    imm.hideSoftInputFromWindow(m_searchtext.getWindowToken(), 0);
	                return true;
				}
				return false;
			}
		});
		m_searchtext.setOnEditorActionListener(new OnEditorActionListener(){

			@Override
			public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
				// TODO Auto-generated method stub
				if (actionId == EditorInfo.IME_ACTION_SEARCH) {
					searchtext = m_searchtext.getText().toString();
					if(!searchtext.equals("")){
						GetMovieList();
					}
					InputMethodManager imm = (InputMethodManager) 
					        getSystemService(Context.INPUT_METHOD_SERVICE);
					    imm.hideSoftInputFromWindow(m_searchtext.getWindowToken(), 0);
	                return true;
	            }
				return false;
			}
			
		});
	}
	
	private void gotoOtherPage(int position)
	{
		//if( position == 0 )
			//gotoPlayListPage();
		
		if( position == 3 )
			gotoProfilePage();
				
	}
	
	private void gotoPlayPage(int position)
	{
		JSONObject item = null;
		try {
			item = moviedata.getJSONObject(position);
		} catch (JSONException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}
		Bundle bundle = new Bundle();
		
		JSONObject data = new JSONObject();
		
		try {
			data.put(Const.POSITION, 0);
			data.put(Const.ARRAY, item.get("path"));
		} catch (JSONException e) {
			e.printStackTrace();
		}
		
		bundle.putString(INTENT_EXTRA, data.toString());
		ActivityManager.changeActivity(this, PlayerActivity.class, bundle, false, null );
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
    		
    		Log.e("name", item.optString("name", ""));
    		((TextView)ViewHolder.get(rowView, R.id.txt_name)).setTextSize(TypedValue.COMPLEX_UNIT_PX, ScreenAdapter.computeHeight(40));
    		
    		((TextView)ViewHolder.get(rowView, R.id.txt_name)).setText(item.optString("name", ""));    	
    		LayoutUtils.setSize(ViewHolder.get(rowView, R.id.txt_name), 250, LayoutParams.WRAP_CONTENT, true);
    		
    		ViewHolder.get(rowView, R.id.txt_name).setFocusable(true);
    		ViewHolder.get(rowView, R.id.txt_name).setFocusableInTouchMode(true);
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
    		
    		
    		((TextView)ViewHolder.get(rowView, R.id.txt_name)).setTextSize(TypedValue.COMPLEX_UNIT_PX, ScreenAdapter.computeHeight(40));    		
    		((TextView)ViewHolder.get(rowView, R.id.txt_name)).setText(item.optString("name", ""));
    		LayoutUtils.setSize(ViewHolder.get(rowView, R.id.txt_name), 250, LayoutParams.WRAP_CONTENT, true);
    		
    		ViewHolder.get(rowView, R.id.txt_name).setFocusable(true);
    		ViewHolder.get(rowView, R.id.txt_name).setFocusableInTouchMode(true);
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
    		String photo = "";
    		try{
    			photo = ServerTask.PHOTO_URL + item.getString("thumb");
    		}catch(Exception e){}
    		int height = ScreenAdapter.computeHeight(700 / 2 - 20);
    		int width = ScreenAdapter.getDeviceWidth() / 6 - 5;
    		LayoutUtils.setSize(ViewHolder.get(rowView, R.id.lay_fragment), width, height, false);    		
    		LayoutUtils.setMargin(ViewHolder.get(rowView, R.id.img_thumbnail), 20, 20, 20, 20, true);    		
    		DisplayImageOptions options = ImageUtils.buildUILOption(R.drawable.ic_launcher).build();
			ImageLoader.getInstance().displayImage(photo, (ImageView)ViewHolder.get(rowView, R.id.img_thumbnail), options);
    	}
    }
	 
	 
}

