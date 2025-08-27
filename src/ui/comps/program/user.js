export default props => {	

	return <div className="User">
    <div className="id">
      ID: { props.state.partnerid }
    </div>
    <div className="Name">
      Name: { props.state.partnername }
    </div>
  </div>
}