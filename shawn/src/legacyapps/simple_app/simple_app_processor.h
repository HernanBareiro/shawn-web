#ifndef __SHAWN_LEGACYAPPS_SIMPLE_APP_SIMPLE_APP_PROCESSOR_H
#define __SHAWN_LEGACYAPPS_SIMPLE_APP_SIMPLE_APP_PROCESSOR_H
#include "_legacyapps_enable_cmake.h"
#ifdef ENABLE_SIMPLE_APP

#include "sys/processor.h"
#include <set>

namespace simple_app
{

   class SimpleAppProcessor
       : public shawn::Processor
   {
   public:
      SimpleAppProcessor();
      virtual ~SimpleAppProcessor();

      virtual void boot( void ) throw();
      virtual bool process_message( const shawn::ConstMessageHandle& ) throw();
      virtual void work( void ) throw();

   protected:
      int last_time_of_receive_;
      std::set<const shawn::Node*> neighbours_;
   };

}

#endif
#endif
