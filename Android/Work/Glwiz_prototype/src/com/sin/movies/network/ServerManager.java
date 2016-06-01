package com.sin.movies.network;import java.util.HashMap;import java.util.List;import com.sin.movies.Const;import common.library.utils.AndroidUtils;import common.network.utils.ResultCallBack;public class ServerManager {			private static void sendRqeust(HashMap<String, String> params, String command,			ResultCallBack callBack) {		ServerTask task = new ServerTask(command, callBack, params);				if (AndroidUtils.getAPILevel() > 12) {			//task.executeOnExecutor(AsyncTask.SERIAL_EXECUTOR, "");			task.execute("");		} else {			task.execute("");		}	}		private static void sendRqeust(List<HashMap<String, String>> paramsList, List<String> commandList,			ResultCallBack callBack) {		ServerTask task = new ServerTask(commandList, callBack, paramsList);				if (AndroidUtils.getAPILevel() > 12) {			//task.executeOnExecutor(AsyncTask.SERIAL_EXECUTOR, "");			task.execute("post");		} else {			task.execute("post");		}	}		private static void sendRqeustGet(HashMap<String, String> params, String command,			ResultCallBack callBack) {		ServerTask task = new ServerTask(command, callBack, params);				if (AndroidUtils.getAPILevel() > 12) {			//task.executeOnExecutor(AsyncTask.SERIAL_EXECUTOR, "");			task.execute("get");		} else {			task.execute("get");		}	}			private static void sendRqeustToOtherService(String url, HashMap<String, String> params, ResultCallBack callBack) {		WebServiceTask task = new WebServiceTask(url, callBack, params);		task.execute("");			}		public static void login(String macaddress, String serialno, ResultCallBack callback)	{		HashMap<String, String> map = new HashMap<String, String>();				map.put("macaddress", macaddress);		map.put("serial", serialno);				sendRqeust(map, "checkdevice", callback);	}	public static void getMovie(int catid, int cid, int pageno, int limit, ResultCallBack callback)	{		HashMap<String, String> map = new HashMap<String, String>();				map.put("catid", "" + catid);		map.put("cid", "" + cid);		map.put("offset", "" + pageno);		map.put("limit", "" + limit);				sendRqeust(map, "getmovies", callback);	}	public static void getCategory(ResultCallBack callback)	{		HashMap<String, String> map = new HashMap<String, String>();			map.put("limit", "");						sendRqeust(map, "getcategory", callback);	}	public static void getCountry(ResultCallBack callback)	{		HashMap<String, String> map = new HashMap<String, String>();			map.put("limit", "");					sendRqeust(map, "getcountry", callback);	}		public static void getCategoryList(String userid, ResultCallBack callback)	{		HashMap<String, String> map = new HashMap<String, String>();				map.put(Const.USER_ID, userid);				sendRqeustGet(map, "category_list", callback);	}		public static void getChannelList(String category_id, ResultCallBack callback)	{		HashMap<String, String> map = new HashMap<String, String>();				map.put("category_id", category_id);				sendRqeustGet(map, "channel_list", callback);	}}