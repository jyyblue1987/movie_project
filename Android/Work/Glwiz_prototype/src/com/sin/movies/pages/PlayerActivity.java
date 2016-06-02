package com.sin.movies.pages;

import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Timer;
import java.util.TimerTask;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import org.w3c.dom.Attr;
import org.w3c.dom.Document;
import org.w3c.dom.Element;
import org.w3c.dom.NamedNodeMap;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;

import com.nostra13.universalimageloader.core.DisplayImageOptions;
import com.nostra13.universalimageloader.core.ImageLoader;
import com.sin.movies.Const;
import com.sin.movies.R;
import com.sin.movies.data.DBManager;
import com.sin.movies.pages.CategoryActivity.ItemMovieGridAdapter;

import android.app.ActionBar.LayoutParams;
import android.app.ProgressDialog;
import android.content.Context;
import android.media.MediaPlayer;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.util.TypedValue;
import android.view.KeyEvent;
import android.view.View;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import common.design.layout.LayoutUtils;
import common.design.layout.ScreenAdapter;
import common.image.load.ImageUtils;
import common.library.utils.AlgorithmUtils;
import common.library.utils.AnimationUtils;
import common.list.adapter.ItemCallBack;
import common.list.adapter.MyListAdapter;
import common.list.adapter.ViewHolder;
import tv.danmaku.ijk.media.player.IMediaPlayer;
import tv.danmaku.ijk.media.player.IMediaPlayer.OnPreparedListener;
import tv.danmaku.ijk.media.widget.MediaController;
import tv.danmaku.ijk.media.widget.VideoView;

public class PlayerActivity extends BaseActivity {
	private VideoView 			mVideoView;
	private MediaController 	m_MediaController = null;	
//	private View mBufferingIndicator;
	
	private JSONObject			m_channelInfo = null;
	private static Timer mTimer;
	private static UpdateDurationTask mDurationTask;
	public String videourl = "";
	@Override
	public void onCreate(Bundle icicle) {
		super.onCreate(icicle);

		setContentView(R.layout.layout_videoview);

		loadComponents();
	}
	
	protected void findViews()
	{
		super.findViews();

		mVideoView = (VideoView) findViewById(R.id.video_view);
		m_MediaController = new MediaController(this);
		mVideoView.setMediaController(m_MediaController);
//		mBufferingIndicator = findViewById(R.id.buffering_indicator);

	}
	
	protected void layoutControls()
	{
		super.layoutControls();
		
		
		
	}
	
	protected void initData()
	{
		super.initData();
		
		Bundle bundle = getIntent().getExtras();
		if( bundle != null )
		{
			try {
				String intentData = bundle.getString(INTENT_EXTRA, ""); 
				m_channelInfo = new JSONObject(intentData);
			} catch (JSONException e) {
				e.printStackTrace();
			}			
		}
		
		
		initTopMenus();
		
		mVideoView.setVideoLayout(VideoView.VIDEO_LAYOUT_STRETCH);
		
		int pos = m_channelInfo.optInt(Const.POSITION, 0);	
		
		videourl = m_channelInfo.optString(Const.ARRAY, "");
		int index = 0;
		if((index = videourl.indexOf("v=")) != -1){
			videourl = videourl.substring(index + 2, videourl.length());
		}
		//new YourAsyncTask().execute();
		playChannel(videourl);
		
	}
	
	private void initTopMenus()
	{
		
	}
	protected void initEvents()
	{
		super.initEvents();
		
		

	}
	
	private void addFavourite()
	{
	}
	
	private void playChannel(String url)
	{
		mVideoView.setVideoPath(url);
		mVideoView.requestFocus();
		mVideoView.start();	
		showLoadingProgress();
		mVideoView.setOnPreparedListener(new OnPreparedListener() {
			@Override
			public void onPrepared(IMediaPlayer mp) {
				// TODO Auto-generated method stub
				hideProgress();
			}
        });
	}
	
	

	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		if (handleKeyDown(keyCode, event)) {
			return true;
		}
		return super.onKeyDown(keyCode, event);
	}
	
	@Override
	public boolean onKeyUp(int keyCode, KeyEvent event) {		
		if (handleKeyUp(keyCode, event)) {
			return true;
		}
		return super.onKeyUp(keyCode, event);
	}
	
	private boolean handleKeyDown(int keyCode, KeyEvent event)
	{
		if( keyCode == KeyEvent.KEYCODE_DPAD_LEFT )
		{
			if( isShowPannel() == false )
			{
				buttonState = BACKRWARD_DOWN;
				scheduleTask();
				
				return true;
			}				
		}
		
		if( keyCode == KeyEvent.KEYCODE_DPAD_RIGHT )
		{
			if( isShowPannel() == false )
			{
				buttonState = FORWARD_DOWN;
				scheduleTask();
				
				return true;				
			}
		}
			
		return false;
	}
	
	private boolean handleKeyUp(int keyCode, KeyEvent event)
	{
		buttonState = NONE_BOTH;
		scheduleTask();
		
		if( keyCode == KeyEvent.KEYCODE_DPAD_CENTER )
		{
			onCenterButtonPressed();
		}
		if( keyCode == KeyEvent.KEYCODE_BACK )
		{
			return onBackButtonPressed();
		}
		
		if( keyCode == KeyEvent.KEYCODE_CHANNEL_UP || 
			keyCode == KeyEvent.KEYCODE_DPAD_UP	||
			keyCode == KeyEvent.KEYCODE_MEDIA_PREVIOUS )
		{
			return onUpButtonPressed();
		}
		
		if( keyCode == KeyEvent.KEYCODE_CHANNEL_DOWN || 
				keyCode == KeyEvent.KEYCODE_DPAD_DOWN ||
				keyCode == KeyEvent.KEYCODE_MEDIA_NEXT )
		{
			return onDownButtonPressed();
		}
		
		if( KeyEvent.KEYCODE_0 <= keyCode && 
				keyCode <= KeyEvent.KEYCODE_9	)
		{
		}
		
		return false;
	}
	
	private boolean isShowPannel()
	{
		return false;		
	}
	
	private boolean onCenterButtonPressed()
	{
		return true;
	}
	
	private boolean onBackButtonPressed()
	{
			return false;
	}
	
	private boolean onUpButtonPressed()
	{
		if( isShowPannel() == true )
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	private boolean onDownButtonPressed()
	{
		if( isShowPannel() == true )
		{
			return false;			
		}
		else
		{
			return true;
		}
	}

	
	@Override
	protected void onResume() {
		super.onResume();
		
		startScheduleTask();
	}
	
	@Override
	protected void onPause() {
		super.onPause();
		
		mDurationTask.cancel();
		mTimer.cancel();
	}
	
	private long previousClick = 0;
	private int  buttonState = NONE_BOTH;
	
	private static final int BACKRWARD_DOWN = 0;
	private static final int FORWARD_DOWN = 1;
	private static final int NONE_BOTH = 2;
	
	private void startScheduleTask()
	{
		buttonState = NONE_BOTH;
		mTimer = new Timer();
	    mDurationTask = new UpdateDurationTask();
		mTimer.schedule(mDurationTask, 0, 4000);
	}
	
    private class UpdateDurationTask extends TimerTask {

        @Override
        public void run() {
        	runOnUiThread(new Runnable() {
                @Override
                public void run() {
                	scheduleTask();
                }
            });
        }
    }
    
	private void  scheduleTask()
	{
		boolean state = false;
		
		long duration = 0;
		duration = mVideoView.getDuration();
		state = mVideoView.isInPlaybackState();
		
		if( buttonState == NONE_BOTH || state == false || duration <= 0 )
		{
			//m_txtState.setVisibility(View.GONE);
			previousClick = 0;
			return;
		}
		
		m_MediaController.show(8000);
		
		if( previousClick == 0 )
			previousClick = System.currentTimeMillis() - 8 * 1000;		
		
		//m_txtState.setVisibility(View.VISIBLE);
		
		long current = System.currentTimeMillis();
		long gap = current - previousClick;
		previousClick = current;
		
		long currentPos = 0;
		
		currentPos = mVideoView.getCurrentPosition();
		
		if( buttonState == BACKRWARD_DOWN )
		{
			//m_txtState.setText("Backward 8x");
			currentPos -= gap * 8;
		}
		else if( buttonState == FORWARD_DOWN )
		{
			//m_txtState.setText("Forward 8x");
			currentPos += gap * 8;
		}
		
		
		
		if( currentPos < 0 || currentPos > duration )
			currentPos = 0;

		mVideoView.seekTo(currentPos);
	}
	private class YourAsyncTask extends AsyncTask<Void, Void, Void>
    {
        ProgressDialog progressDialog;
        String videoUrl = "";

        @Override
        protected void onPreExecute()
        {
            super.onPreExecute();
            progressDialog = ProgressDialog.show(PlayerActivity.this, "", "Loading Video wait...", true);
        }

        @Override
        protected Void doInBackground(Void... params)
        {
            try
            {
                //String url = "http://www.youtube.com/watch?v=1FJHYqE0RDg";
                videoUrl = getUrlVideoRTSP(videourl);
                
            }
            catch (Exception e)
            {
                Log.e("Login Soap Calling in Exception", e.toString());
            }
            return null;
        }

        @Override
        protected void onPostExecute(Void result)
        {
            super.onPostExecute(result);
            progressDialog.dismiss();

            playChannel(videoUrl);
        }

    }

	public static String getUrlVideoRTSP(String urlYoutube)
    {
        try
        {
            String gdy = "http://gdata.youtube.com/feeds/api/videos/";
            DocumentBuilder documentBuilder = DocumentBuilderFactory.newInstance().newDocumentBuilder();
            String id = extractYoutubeId(urlYoutube);
            URL url = new URL(gdy + id);
            HttpURLConnection connection = (HttpURLConnection) url.openConnection();
            Document doc = documentBuilder.parse(connection.getInputStream());
            Element el = doc.getDocumentElement();
            NodeList list = el.getElementsByTagName("media:content");///media:content
            String cursor = urlYoutube;
            for (int i = 0; i < list.getLength(); i++)
            {
                Node node = list.item(i);
                if (node != null)
                {
                    NamedNodeMap nodeMap = node.getAttributes();
                    HashMap<String, String> maps = new HashMap<String, String>();
                    for (int j = 0; j < nodeMap.getLength(); j++)
                    {
                        Attr att = (Attr) nodeMap.item(j);
                        maps.put(att.getName(), att.getValue());
                    }
                    if (maps.containsKey("yt:format"))
                    {
                        String f = maps.get("yt:format");
                        if (maps.containsKey("url"))
                        {
                            cursor = maps.get("url");
                        }
                        if (f.equals("1"))
                            return cursor;
                    }
                }
            }
            return cursor;
        }
        catch (Exception ex)
        {
            Log.e("Get Url Video RTSP Exception======>>", ex.toString());
        }
        return urlYoutube;

    }

	protected static String extractYoutubeId(String url) throws MalformedURLException
    {
        String id = null;
        try
        {
            String query = new URL(url).getQuery();
            if (query != null)
            {
                String[] param = query.split("&");
                for (String row : param)
                {
                    String[] param1 = row.split("=");
                    if (param1[0].equals("v"))
                    {
                        id = param1[1];
                    }
                }
            }
            else
            {
                if (url.contains("embed"))
                {
                    id = url.substring(url.lastIndexOf("/") + 1);
                }
            }
        }
        catch (Exception ex)
        {
            Log.e("Exception", ex.toString());
        }
        return id;
    }
	
}

