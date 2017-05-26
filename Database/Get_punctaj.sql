create or replace function get_punctaj(v_id_kid integer,v_id_test integer) return number as
  punctaj number :=0;
  v_data timestamp;
begin
  SELECT max(data) into v_data from tw_answers  where id_kid=v_id_kid and id_test=v_id_test and id_intrebare=1;
  SELECT sum(solved) into punctaj from tw_answers where id_kid=v_id_kid and id_test=v_id_test and data<=CURRENT_TIMESTAMP and data>=v_data;
  punctaj:=punctaj*10;
  return punctaj; 
end;


SELECT get_punctaj(1,1) from dual;