#include "legacyapps/simple_app/simple_app_message.h"
#ifdef ENABLE_SIMPLE_APP

namespace simple_app
{
	SimpleAppMessage::
		SimpleAppMessage()
	{}

	SimpleAppMessage::
		SimpleAppMessage(int size)
	{
		setSize(size);
	}
	
	SimpleAppMessage::
		~SimpleAppMessage()
	{}
}
#endif
