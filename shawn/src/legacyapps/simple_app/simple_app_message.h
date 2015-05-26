#ifndef __SHAWN_LEGACYAPPS_SIMPLE_APP_SIMPLE_APP_MESSAGE_H
#define __SHAWN_LEGACYAPPS_SIMPLE_APP_SIMPLE_APP_MESSAGE_H
#include "_legacyapps_enable_cmake.h"
#ifdef ENABLE_SIMPLE_APP

#include "sys/message.h"

namespace simple_app
{

   class SimpleAppMessage
       : public shawn::Message
   {
   public:
	   SimpleAppMessage();
	   SimpleAppMessage(int);
	   virtual ~SimpleAppMessage();
   };

}

#endif
#endif
