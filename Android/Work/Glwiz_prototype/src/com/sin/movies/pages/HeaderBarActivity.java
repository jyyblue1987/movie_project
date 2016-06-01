package com.sin.movies.pages;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Locale;
import java.util.Timer;
import java.util.TimerTask;

import com.sin.movies.R;

import android.util.TypedValue;
import android.widget.ImageView;
import android.widget.TextView;
import common.design.layout.LayoutUtils;
import common.design.layout.ScreenAdapter;


public class HeaderBarActivity extends BaseActivity {
	ImageView 		m_imgLogo = null;
	
	TextView		m_txtMainMenu = null;
	TextView		m_txtTime = null;
	
	private static Timer mTimer;
	//private static UpdateDurationTask mDurationTask;

	
	protected void findViews()
	{
	}
	
	protected void layoutControls()
	{
		
	}
	
	protected void initEvents()
	{
		
		
	}
	
	protected void gotoBackPage()
	{
		finishView();		
	}
	
	protected void gotoNextPage()
	{
		
	}
	
	protected void initData()
	{
	}
	
//    private class UpdateDurationTask extends TimerTask {
//
//        @Override
//        public void run() {
//        	runOnUiThread(new Runnable() {
//                @Override
//                public void run() {
//                	scheduleTask();
//                }
//            });
//        }
//    }
    
    private void  scheduleTask()
	{
//    	Date date = new Date();
//		SimpleDateFormat dateformat = new SimpleDateFormat("dd/MM/yyyy");
//		String datestr = dateformat.format(date);
//		
//		SimpleDateFormat timeformat = new SimpleDateFormat("h:mm a", Locale.ENGLISH);
//		String timestr = timeformat.format(date);
//		
//		m_txtTime.setText(timestr + "\r\n" + datestr);
		
	}
    
	private void startScheduleTask()
	{
//		mTimer = new Timer();
//	    mDurationTask = new UpdateDurationTask();
//		mTimer.schedule(mDurationTask, 0, 1000);
	}
	
	@Override
	protected void onResume() {
		super.onResume();
		
		//startScheduleTask();
	}
	
	@Override
	protected void onPause() {
		super.onPause();
//		
//		mDurationTask.cancel();
//		mTimer.cancel();
	}	
}
