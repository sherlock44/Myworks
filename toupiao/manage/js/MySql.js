var MySql = (function(){
	
	var scripts = document.getElementsByTagName('script');
	var path = scripts[scripts.length-1].src.replace(/[^\/]+$/,'');
	
	var ms = function( database, server, user, password ) {
		this.database = database || 'mysql';
		this.server = server || 'localhost';
		this.user = user || 'root';
		this.password = password || '';
	}
	
	ms.prototype = {
		query : function( sql, success, error ) {
			if( !isString(sql) ) {
				throw new Error('sql\u53c2\u6570\u4e0d\u53ef\u6267\u884c');
			}
			success = isFunction(success) ? success : this.success;
			error = isFunction(error) ? error : this.error;
			doQuery.call(this,sql,success,error)
		}
		,
		charset : "UTF-8"
		,
		php : path+"MySql.php"
	}
	
	function doQuery( sql, success, error ) {
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
			if( xhr.readyState==4 ) {
				doLoad.call(this,xhr,success,error);
			}
		};
		xhr.open('POST',this.php);
		xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset='+this.charset);
		xhr.send( createData(this,sql) );
	}
	
	function doLoad( xhr,success,error ) {
		if( xhr.status!=200 ) {
			doError('\u83b7\u53d6\u6570\u636e\u9519\u8bef:\u72b6\u6001\u7801='+xhr.status,error)
			return;
		}
		try {
			var result = xhr.responseText;
			result = window.JSON ? JSON.parse(result) : eval("("+result+")");
		} catch (e) {
			doError('\u6570\u636e\u89e3\u6790\u9519\u8bef:'+e.message,error);
			return;
		}
		
		if( result.status ) {
			delete( result.status );
			doSuccess( result, success );
		} else {
			doError( "Sql\u6267\u884c\u9519\u8bef:"+result.error, error );
		}
	}
	
	function doSuccess(data,success) {
		if( !isFunction( success ) ) {
			console.log('\u83b7\u53d6\u5230\u6570\u636e:',data);
			return;
		}
		success(data);
	}
	
	function doError(mes,error) {
		if( !isFunction( error ) ) {
			console.error(mes);
			return;
		}
		error(mes);
	}
	
	function createData( attributs, sql ) {
		var datas = ["sql="+encodeURI(sql)];
		datas.push("database="+encodeURI(attributs.database));
		datas.push("server="+encodeURI(attributs.server));
		datas.push("user="+encodeURI(attributs.user));
		datas.push("password="+encodeURI(attributs.password));
		return datas.join("&");
	}
	
	
	function isFunction( o ) {
		return typeof(o)=='function' || o instanceof Function;
	}
	
	function isString( o ) {
		return typeof(o)=='string' || o instanceof Function;
	}
	
	return ms;
	
})();