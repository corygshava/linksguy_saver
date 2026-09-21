<?php
	require_once __DIR__.'/../../_packages/loader.php';
	maloader::load_package('fileops');

	abstract class Model{
		public $filename = '';
		public $priKey = 'id';
		private $fyls = null;

		public $data = null;
		public $use_as_is = false;
		public $last_op_result = true;
		public $filespath = __DIR__.'/../../_datazone/';
		public static $showlogs = true;
		public $dftres = [
			"success" => true,
			'result' => true,
			"message" => "default",
			"sendme" => null,
			"runlog" => []
		];
		public $mylogs = [];

		// meth guys
		private function load_all(){
			$myfile = $this->filespath.$this->filename.".json";
			$fl = $this->fyls;

			if(is_file($myfile)){
				// $rd = ($myfile);
				$rd = $fl::saferead($myfile,true,105);

				if($rd !== false){
					$parsed = json_decode($rd,true);
					return $parsed;
				} else {
					return [];
				}
			} else {
				return [];
			}
		}

		private function save_all($mydata){
			$myfile = $this->filespath.$this->filename.".json";
			$fl = new fl_();

			if(!is_file($myfile)){
				$fl::c_file($myfile);
			}

			$wot = isset($mydata->data) ? $mydata->data : $mydata;
			$verdict = $fl::safe_write_text($myfile,json_encode($wot,JSON_PRETTY_PRINT),true,12);

			return $verdict;
		}

		private function update_single(array | object $v= []){
			$v = $this->toArray($v);
			$this->_log(['passed' => $v]);

			if(array_is_list($v)){
				$this->_log('a list was passed to update_single, i only accept assocs');
				return null;
			}

			if(!isset($v[$this->priKey])){
				$this->_log('invalid record passed');
				$this->_log(['invalid_record' => $v]);
				return null;
			}

			$id = $v[$this->priKey];
			$all = $this->load_all();
			$my_n = -1;
			$n = 0;

			foreach ($all as $r) {
				if($r[$this->priKey] == $id){
					$my_n = $n;
				}
				$n += 1;
			}

			if($my_n < 0){
				$this->_log('invalid record');
				return null;
			}

			$oldme = $all[$my_n];
			$this->_log(['oldme' => $oldme]);

			$newme = [...$oldme,...$v];
			$this->_log(['newme' => $newme]);

			$all[$my_n] = $newme;

			$this->_log('updated the stuff');
			$this->save_all($all);

			return $newme;
		}

		private function save_log($value=''){
			$this->mylogs[] = $value;
		}
		private function _log($v=''){
			$this->save_log($v);
		}

		// public meth guys
		public function init($fname){
			$this->fyls = new fl_();
			$this->filename = $fname;
		}

		public function get_all(){
			$fetched = $this->load_all();
			$this->data = $fetched;

			return $fetched;
		}
		public function get() {
			return $this->data;
		}
		public function first(){
			$dta = $this->data;
			if($dta == null){return null;};

			if(array_is_list($dta)){
				if(empty($dta)){
					return null;
				}

				return $dta[0];
			} else {
				return $dta;
			}
		}
		public function count(){
			$dta = $this->data;
			if($dta == null){return 0;};

			if(array_is_list($dta)){
				if(empty($dta)){
					return 0;
				}

				return count($dta);
			} else {
				return 1;
			}
		}

		public function put_all($wot){
			$fetched = $this->save_all($wot);
			$this->last_op_result = $fetched;

			return $fetched;
		}
		public function add_one($w){
			$json = json_encode($w);
			$wot = json_decode($json,true);
			$dd = $this->get_all();

			if(!isset($wot['id'])){
				$wot['id'] = count($dd) + 1;
			}

			$dd[] = $wot;
			$this->put_all($dd);
			$this->data = $wot;

			return $this;
		}

		public function paginate($count = 15,int $page = null){
			$u_scheme = $_SERVER['REQUEST_SCHEME'];		// http or s:
			$u_host = $_SERVER['HTTP_HOST'];
			$u_uri = $_SERVER['REQUEST_URI'];
			$base_url = "{$u_scheme}://{$u_host}{$u_uri}";

			$page = $page ?? (int)($_GET['page'] ?? 1);
			$page = max(1, $page);

			$fetched = $this->data;
			$this->_log('current data: ');
			$this->_log($fetched);
			$all_data = [];

			if($this->use_as_is){
				$all_data = $fetched;
				$this->_log('using it as is');
				$this->_log($all_data);
			} else {
				$all_data = $fetched == null ? $this->get_all() : $fetched;
				$this->_log('running black magic on it');
			}
			$all_count = count($all_data);
			$last_page = max(1, ceil($all_count / $count));
			$page = min($page, $last_page);

			$offset = ($page - 1) * $count;
			$data = array_slice($all_data, $offset, $count);

			$from = $all_count == 0 ? 0 : $offset + 1;
			$to = min($offset + $count, $all_count);
			// $links

			$this->_log($base_url);

			// Build pagination links
			$links = [];
			$base_path = explode('?', $base_url)[0];
			
			// Previous link
			$links[] = [
				'url' => $page > 1 ? $base_path.'?page='.($page - 1) : null,
				'label' => '&laquo; Previous',
				'page' => $page > 1 ? $page - 1 : null,
				'active' => false
			];
			
			// Page number links
			for($i = 1; $i <= $last_page; $i++){
				$links[] = [
					'url' => $base_path.'?page='.$i,
					'label' => (string)$i,
					'page' => $i,
					'active' => $i === $page
				];
			}
			
			// Next link
			$links[] = [
				'url' => $page < $last_page ? $base_path.'?page='.($page + 1) : null,
				'label' => 'Next &raquo;',
				'page' => $page < $last_page ? $page + 1 : null,
				'active' => false
			];
			
			return [
				'current_page' => $page,
				'data' => $data,
				'first_page_url' => $base_path.'?page=1',
				'from' => $from,
				'last_page' => $last_page,
				'last_page_url' => $base_path.'?page='.$last_page,
				'links' => $links,
				'next_page_url' => $page < $last_page ? $base_path.'?page='.($page + 1) : null,
				'path' => $base_path,
				'per_page' => $count,
				'prev_page_url' => $page > 1 ? $base_path.'?page='.($page - 1) : null,
				'to' => $to,
				'total' => $all_count
			];
		}

		public function where($field = 'id',$operator = null,$value = null){
			$f = $this->data;
			$a_data = $f == null ? $this->get_all() : $f;
			$out = [];

			$this->_log('starting the search');

			foreach ($a_data as $r) {
				$g = false;

				$this->_log($r);

				if(isset($r[$field])){
					$vl = $r[$field];

					if($operator == '='){
						$g = $vl == strtolower("$value");
					} elseif($operator == '<>') {
						$g = $vl != strtolower("$value");
					} elseif($operator == 'like'){
						$hay = strtolower("$vl");
						$g = str_contains($hay, strtolower("$value"));
						// $this->_log("");
						// $this->_log($g ? 'its good' : 'its not');
					}
				}

				$this->_log(['condition' => "$field $operator $value"]);
				$this->_log($g ? 'its good' : 'its not');

				if($g){
					$out[] = $r;
				}
			}

			$this->_log([
				'before_where' => $this->data,
				'after_where' => $out,
			]);
			$this->data = $out;

			$this->_log([
				'actual_after_where' => $this->data,
			]);
			return $this;
		}

		public function latest(){
			$dt = $this->data;
			$all = $dt == null ? $this->get_all() : $dt;
			$this->data = array_reverse($all);
			return $this;
		}

		public function assign_data($wot){
			$this->data = $wot;
			$this->use_as_is = true;
			return $this;
		}

		public function update(array | object $wot = []){
			$dta = $this->data;
			$f = [];

			$this->_log(['update_passed' => $wot]);

			if($dta == null){
				return null;
			}

			$this->_log(['old data' => $this->data]);
			if(array_is_list($dta)){
				$this->_log('updating the list of items');
				// update each element in this list and run an update_single on each
				foreach($dta as $d){
					$f[] = $this->update_single($this->toObject($wot));
					$this->_log('an item was updated');
				}
			} else {
				$this->_log('updating the item');
				// run update_single on the current item
				$f = $this->update_single($this->toObject($wot));
			}

			$fin = $f;
			$this->data = $fin;
			$this->_log(['new data' => $this->data]);

			return $this;
		}

		// finalizers
		public function toObject($v = null){
			if($v == null){
				$dt = $this->data;
			} else {
				$dt = $v;
			}

			$json = json_encode($dt);
			$prsd = json_decode($json);

			return $prsd;
		}
		public function toArray($v = null){
			if($v == null){
				$dt = $this->data;
			} else {
				$dt = $v;
			}

			$json = json_encode($dt);
			$prsd = json_decode($json,true);

			return $prsd;
		}
	}